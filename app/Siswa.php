<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['nis', 'nama_lengkap', 'kelas'];
  
}
