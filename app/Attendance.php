<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $table='attendance';
    protected $guarded = ['id'];

    public static function postAttendance($person_id, $datetime, $tv_or_online){

        Attendance::create([
                    'person_id' => $person_id,
                    'date_taken' => $datetime,
                    'flow_option' => $tv_or_online
        ]);
        
        return true;
    }

    public static function getAttendanceReport($date_filter){

        // $attendanceReport = Attendance::leftJoin('persons', 'persons.id','=','attendance.person_id')
        //                               ->leftJoin('council', 'persons.council_id','=','councils.id')
        //                               ->where()

    }

    
}
