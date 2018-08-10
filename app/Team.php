<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $table = 'team';

    public $fillable = [
        'team_name', 'members'
    ];

    public $appends = ['meembersId', 'membersJson'];

    protected function getMembersAttribute()
    {
        $members = @$this->attributes['members'];
        if (!empty($members)) {
            $members = explode("|", $members);
            foreach ($members as $row) {
                $player = \App\Players::find($row);
                $players[] = $player;
            }
            return $players;
        } else {
            return null;
        }
    }

    protected function getMembersJsonAttribute()
    {
        $members = @$this->attributes['members'];
        if (!empty($members)) {
            $members = explode("|", $members);
            $return = [];
            foreach ($members as $row) {
                $player = \App\Players::find($row);
                $return[] = [
                    "id" => $player->id,
                    "name" => $player->name
                ];
            }
            return json_encode($return);
        } else return null;
    }

    protected function getMembersIdAttribute()
    {
        $members = @$this->attributes['members'];
        return $members;
    }
}
