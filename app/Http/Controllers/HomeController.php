<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $start = Carbon::createFromFormat('d/m/Y H:i:s', '10/08/2017 16:00:00');
        $end = Carbon::createFromFormat('d/m/Y H:i:s', '10/08/2017 18:00:00');
        $kelas = 'XII-RPL1';
        
        $data['key'] = [
            MCRYPT_DES, MCRYPT_3DES, MCRYPT_CAST_128, MCRYPT_CAST_256, MCRYPT_GOST, MCRYPT_TWOFISH, MCRYPT_BLOWFISH, MCRYPT_RIJNDAEL_128, MCRYPT_RIJNDAEL_192, MCRYPT_RIJNDAEL_256, MCRYPT_LOKI97, MCRYPT_TRIPLEDES, MCRYPT_RC2, MCRYPT_SAFERPLUS, MCRYPT_SERPENT, MCRYPT_XTEA
        ];
        
        $data['user'] = $user = \Auth::user();
        $data['cipher'] = $cipher = session('cipher');
        
        $data['enemies'] = \App\Players::where('id', '<>', $user->id)->whereHas('cipher')->where('kelas', $user->kelas)->get();
                
        $answer = $user->answer;
        
        $id_player = [];
        foreach ($answer as $row) {
            $id_player[] = $row->cipher->player->id;
        }
        $data['answered'] = $id_player;
        
        $data['guessed'] = @\App\Answers::where('id_cipher', $user->cipher->id)->get()->count();
        
        if (empty($cipher)) $data['cipher'] = $user->cipher;
        
        if (empty($data['cipher'])) $data['enemies'] = [];
        
        if (Carbon::now()->between($start, $end)) $data['start'] = true;
        
        $data['start_date'] = $start;
        
        if ($user->kelas != $kelas) $data['start'] = false;
        
        return view('home')->with($data);
    }
    
    public function registrasi()
    {
        return view('register');
    }
    
    public function doRegister(Request $request)
    {
        $validate = [
            'team' => 'required',
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
        $player = \App\Players::find(@$input['id']);
        $plain = $player->cipher->plain_text;
        
        if ($answer != $plain) {
            return redirect('/')->with('error', 'Wrong answer <strong>' . $answer . '</strong> for Team <strong>' . $player->username . '</strong>.');
        } else {
            $id_cipher = $player->cipher->id;
            $id_team = \Auth::user()->id;
            
            $answer = new \App\Answers;
            $answer->id_cipher = $id_cipher;
            $answer->id_team = $id_team;
            $answer->save();
            
            return redirect('/')->with('success', 'Correct answer <strong>' . $input['answer'] . '</strong> for Team <strong>' . $player->username . '</strong>.');
        }
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
}
