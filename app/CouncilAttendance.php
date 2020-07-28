<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouncilAttendance extends Model
{
    //
    protected $table = 'council_attendance';
    protected $guarded = ['id'];

    

    public static function getAllCouncilReport($date)
    {
        //test bantama as a council

    }
}
