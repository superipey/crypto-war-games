<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers extends Model
{
    public $fillable = [
        'id_team', 'id_cipher'
    ];
    
    public function player() {
        return $this->hasOne('\App\Players', 'id', 'id_team');
    }
    
    public function cipher() {
        return $this->hasOne('\App\Ciphers', 'id', 'id_cipher');
    }
}
