<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Council;
use App\Attendance;

class AttendanceController extends Controller
{

    public function index(){

        return view('take_attendance');

    }
    //
    public function postAttendance(Request $request){

        //posted form comes here ...
        $person_id = $request->get('person_name');
        $datetime = $request->get('date');
        $tv_or_online = $request->get('tv_or_online');
        $rank = $request->get('rank');

        $person = Person::find($person_id);
        
        $person->rank = $rank;
        $person->save();

        Attendance::postAttendance($person_id, $datetime, $tv_or_online);

        return view('attendance_submit')
                ->with('person', $person);

    }

    public function searchCouncil(Request $request){

        $council = $request->get('search');
        $councils = Council::search($council);

        return response()->json($councils);

    }

    public function searchPerson(Request $request){

        $name = $request->get('search');

        $council_id = $request->get('council_id');

        $persons = Person::search($name, $council_id);

        return response()->json($persons);

    }

    public function attendanceReport(Request $request){
        $date_filter = $request->get('date_filter');
        if (! $date_filter){
            $date_filter = date("Y-m-d");
        }

        $allPersons = Person::getAllPerson();

        return view('results')
            ->with('date', $date_filter)
            ->with('allPersons', $allPersons);

    }
}
