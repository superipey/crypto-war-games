<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $data = [];
        $schedule = \App\Schedule::all();
        foreach ($schedule as $row) {
            $data['schedule_' . $row->type] = \Carbon\Carbon::now()->between($row->start, $row->end);
        }

        $data['key'] = [
            'aes-128-cbc','aes-128-cfb','aes-128-ctr','aes-192-cbc','aes-256-cbc','bf-cbc','camellia-128-cbc','camellia-192-cbc','cast5-cbc','cast5-cfb','des-cbc','des-ofb','gost89','idea-cbc','idea-cfb','rc2-cbc','seed-cbc','seed-cfb'
        ];
        
        $data['user'] = $user = \Auth::user();
        $kelas = $user->kelas;

        $data['cipher'] = $cipher = session('cipher');

        $data['single'] = \App\Ciphers::with('player')->where('status', 1)->whereHas('player', function($q) use ($kelas) {
            $q->where('kelas', $kelas);
        })->first();

        $data['rank'] = [];
        $rank = \App\Answers::select('id_team', \DB::raw('COUNT(id) as score'))->groupBy('id_team')->orderByDesc('score')->get();
        foreach ($rank as $row) {
            if ($row->player->kelas != $kelas) continue;
            $r = [
                'name' => $row->player->name,
                'score' => $row->score
            ];
            $data['rank'][] = $r;
        }

        return view('home')->with($data);
    }
    
    public function registrasi()
    {
        $data = [];
        $schedule = \App\Schedule::where('type', 1)->first();
        if (!empty($schedule)) {
            $data['schedule_1'] = \Carbon\Carbon::now()->between($schedule->start, $schedule->end);
        }
        return view('register', $data);
    }
    
    public function doRegister(Request $request)
    {
        $validate = [
            'nis' => 'required|unique:players,nis',
            'username' => 'required|unique:players,username',
            'password' => 'required|min:6',
            'repassword' => 'required|same:password',
            'kelas' => 'required'
        ];
        $this->validate($request,$validate);
        $input = $request->all();
        
        $status = \App\Players::create($input);
        
        if ($status) return redirect('/login')->with('success', 'Registration Success. Please login.');
        else return redirect('/register')->with('error', 'Registration Failed. Please try again.');
    }
    
    public function submitCipher(Request $request)
    {
        $validate = [
            'plain_text' => 'required',
            'shift_number' => 'required',
            'cipher_text_1' => 'required',
            'cipher_text_2' => 'required',
            'key' => 'required',
            'salt_8' => 'required|size:8',
            'salt_16' => 'required|size:16',
            'salt_24' => 'required|size:24',
            'salt_32' => 'required|size:32',
            'salt_any' => 'required',
            'real_salt' => 'required',
        ];
                
        $this->validate($request,$validate);
        
        $input = $request->all();
        $data['cipher'] = (object) $input;
        
        $user = \Auth::user();
                
        // Check Cipher Text Level 1
        $plain = strtoupper($input['plain_text']);
        $cipher_text_1 = strtoupper($input['cipher_text_1']);
        $shift_number = $input['shift_number'];
        
        $decrypt = $this->Decipher($cipher_text_1, $shift_number);
        
        if ($plain != $decrypt) {
            $data['error'] = 'Wrong Cipher Text Level 1';
            return redirect('/')->with($data);
        }
        
        // Check Cipher Text Level 2
        $key = $input['key'];
        $real_salt = $input['real_salt'];
        $salt = $input[$real_salt];
        $cipher_text_2 = $input['cipher_text_2'];
        
        $iv = @mcrypt_create_iv(mcrypt_get_iv_size($key, MCRYPT_MODE_ECB), MCRYPT_RAND);
        $plain = @base64_decode($cipher_text_2);
        $plain = @mcrypt_decrypt($key, $salt, $plain, MCRYPT_MODE_ECB, $iv);   
        
        $plain = preg_replace('/[^\PC\s]/u', '', $plain);
        
        if ($plain != $cipher_text_1) {
            $data['error'] = 'Wrong Cipher Text Level 2';
            return redirect('/')->with($data);
        }
        
        $input['id_team'] = $user->id;
        $status = \App\Ciphers::create($input);
        
        if ($status) return redirect('/login')->with('success', 'Success. Lets play the game.');
        else return redirect('/register')->with('error', ' Failed. Please try again.');
    }
    
    public function answer(Request $request)
    {
        $input = $request->all();
        $answer = @$input['answer'];
        $cipher = \App\Ciphers::find(@$input['id']);
        $plain = $cipher->plain_text;

        $checkMaksimal = \App\Answers::where('id_team', \Auth::user()->id)->count();

        if ($checkMaksimal >= 10) {
            return redirect('/')->with('error', 'Maximum answer reached (10)');
        }

        $answered = \App\Answers::where('id_cipher', $cipher->id);
        if ($answered->count() != 0) {
            return redirect('/')->with('error', 'Soal #' . $cipher->id .' sudah terjawab oleh ' . $answered->first()->player->name);
        }
        
        if ($answer != $plain) {
            return redirect('/')->with('error', 'Wrong answer <strong>' . $answer . '</strong> for Team <strong>' . $cipher->player->username . '</strong>.');
        } else {
            $id_cipher = $cipher->id;
            $id_team = \Auth::user()->id;
            
            $answer = new \App\Answers;
            $answer->id_cipher = $id_cipher;
            $answer->id_team = $id_team;
            $answer->save();

            if ($cipher->status == 1) {
                $cipher->status = 2;
                $cipher->save();

                $kelas = \Auth::user()->kelas;

                $nextQuestion = \App\Ciphers::with('player')->where('status', '<>', 2)->whereHas('player', function($q) use ($kelas) {
                    $q->where('kelas', $kelas);
                })->inRandomOrder()->first();

                $nextQuestion->status = 1;
                $nextQuestion->save();

            }
            
            return redirect('/')->with('success', 'Correct answer <strong>' . $input['answer'] . '</strong> for Team <strong>' . $cipher->player->username . '</strong>.');
        }
    }
    
    public function guess(Request $request)
    {
        $time = Carbon::createFromFormat('d/m/Y H:i:s', '10/08/2017 17:30:00');
        if (Carbon::now()->lt($time)) return redirect('/')->with('error', 'This feature open at last 30 minutes.');
        
        $validate = [
            'cipher_text_1' => 'required|max:7',
            'shift_number' => 'required',
        ];
        $this->validate($request,$validate);
        
        $input = $request->all();
        
        $cipher_text_1 = strtoupper($input['cipher_text_1']);
        $shift_number = $input['shift_number'];
        
        $decrypt = $this->Decipher($cipher_text_1, $shift_number);
        
        return redirect('/')->with('success', $decrypt);
    }
    
    function Cipher($ch, $key)
    {
        if (!ctype_alpha($ch))
            return $ch;

        $offset = ord(ctype_upper($ch) ? 'A' : 'a');
        return chr(fmod(((ord($ch) + $key) - $offset), 26) + $offset);
    }

    function Encipher($input, $key)
    {
        $output = "";

        $inputArr = str_split($input);
        foreach ($inputArr as $ch)
            $output .= $this->Cipher($ch, $key);

        return $output;
    }

    function Decipher($input, $key)
    {
        return $this->Encipher($input, 26 - $key);
    }

    function soal(Request $request)
    {
        $data['key'] = [
            'aes-128-cbc','aes-128-cfb','aes-128-ctr','aes-192-cbc','aes-256-cbc','bf-cbc','camellia-128-cbc','camellia-192-cbc','cast5-cbc','cast5-cfb','des-cbc','des-ofb','idea-cbc','idea-cfb','rc2-cbc','seed-cbc','seed-cfb'
        ];
        $words = [
            'sepeda motor',
            'impian harapan',
        ];

        foreach ($words as $word) {
            $word = strtoupper($word);
            $rand = rand(0, 17);
            $shift = rand(1, 25);
            $cipher_method = $data['key'][$rand];
            $ivlen = openssl_cipher_iv_length($cipher_method);

            $salt_8 = substr(hash('sha256', openssl_random_pseudo_bytes(8)), 0, 8);
            $salt_16 = substr(hash('sha256', openssl_random_pseudo_bytes(16)), 0, 16);

            if ($ivlen == 8) $salt = $salt_8;
            if ($ivlen == 16) $salt = $salt_16;

            $cipher_text_1 = $this->Encipher($word, $shift);
            $cipher_text_2 = openssl_encrypt($cipher_text_1, $cipher_method, $salt, 0, $salt);

            $insert = [
                'id_team' => 6,
                'plain_text' => $word,
                'shift_number' => $shift,
                'cipher_text_1' => $cipher_text_1,
                'cipher_text_2' => $cipher_text_2,
                'key' => $cipher_method,
                'salt_8' => $salt_8,
                'salt_16' => $salt_16,
                'real_salt' => 'salt_' . $ivlen,
                'status' => 0
            ];
            \App\Ciphers::create($insert);
        }
    }
}
