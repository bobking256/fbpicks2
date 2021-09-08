<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $fillable=[
        'name',
        'abbrev',
        'gif',
        'city',
        'conference',
        'division',
    ];
}
