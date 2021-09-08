<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    protected $fillable=[
        'week_no',
        'hometeam_id',
        'awayteam_id',
        'point_spread',
        'favoriteteam_id',
        'hometeam_pts',
        'awayteam_pts',
        'default_game',
        'gamedate',
        'noline',
    ];
}
