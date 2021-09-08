<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resultsall extends Model
{
    //
    protected $fillable = [
        'user_id',
        'week_no',
        'p1',
        'p2',
        'p3',
        'p4',
        'p5',
        'p6',
        'p7',
        'p8',
        'p9',
        'p10',
        'p11',
        'p12',
        'p13',
        'p14',
        'p15',
        'p16',
        'totpts',
    ];

    public function users(){
        return $this->belongsTo(User::class,'user_id');
    }

}
