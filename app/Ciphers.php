<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciphers extends Model
{
    public $fillable = [
        'id_team', 'plain_text', 'shift_number', 'cipher_text_1', 'cipher_text_2', 'key',
        'salt_8', 'salt_16', 'salt_24', 'salt_32', 'salt_any', 'real_salt'
    ];
    
    public function player() {
        return $this->belongsTo('\App\Players', 'id_team', 'id');
    }
}
