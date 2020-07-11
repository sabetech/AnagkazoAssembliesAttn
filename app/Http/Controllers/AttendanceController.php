<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Attendance;

class AttendanceController extends Controller
{

    public function index(){

        return view('take_attendance');

    }
    //
    public function postAttendance(Request $request){

        //posted form comes here ...
        $name = $request->get('person_name');
        $datetime = $request->get('attendance_date');
        $tv_or_online = $request->get('tv_or_online');

        Attendance::postAttendance($name, $datetime, $tv_or_online);

        return view('attendance_submit');

    }

    public function searchCouncil(Request $request){

        $council = $request->get('search');
        $councnils = Person::search($council);

        return response()->json($persons);

    }

    public function searchPerson(Request $request){

        $name = $request->get('search');
        $persons = Person::search($name);

        return response()->json($persons);

    }
}
