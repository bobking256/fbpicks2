<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    protected $fillable = [
        'opt_picktime',
        'message',
        'lockoption',
        'lock',
        'register',
    ];
}
