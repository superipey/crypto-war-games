<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Players extends Authenticatable
{
    use Notifiable;
    
    public $fillable = [
        'nis', 'name', 'username', 'password', 'kelas'
    ];
    
    public function cipher() {
        return $this->hasOne('\App\Ciphers', 'id_team', 'id');
    }
    
    public function answer() {
        return $this->hasMany('\App\Answers', 'id_team', 'id');
    }
}
