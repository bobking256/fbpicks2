<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pick extends Model
{
    //
    protected $fillable=[
        'user_id',
        'week_no',
        'pt5',
        'pt3',
        'pt1',
        'bonus',
        'def'
    ];

}
