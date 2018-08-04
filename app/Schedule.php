<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public $table = 'schedule';

    public $fillable = [
        'type', 'start', 'end'
    ];

    protected $dates = ['start', 'end'];
}
