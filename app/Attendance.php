<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $table='attendance';

    public static function postAttendance($person_id, $datetime, $tv_or_online){

        Attendance::create([
                    'person_id' => $person_id,
                    'date_taken' => $datetime,
                    'flow_option' => $tv_or_online
        ]);
        
        return true;
    }
}
