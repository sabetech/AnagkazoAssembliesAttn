<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use App\Council;
use App\Attendance;
use App\ToggleForm;
use App\Exports\ExportAttendance;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{

    public function index()
    {
        $formStatus = ToggleForm::first();
        return view('take_attendance')
            ->with('formStatus', $formStatus);
    }
    //
    public function postAttendance(Request $request)
    {

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
            ->with('date', $datetime)
            ->with('msg', 'Your Attendance has been recorded Successfully!')
            ->with('person', $person);
    }

    public function searchCouncil(Request $request)
    {

        $council = $request->get('search');
        $councils = Council::search($council);

        return response()->json($councils);
    }

    public function searchPerson(Request $request)
    {

        $name = $request->get('search');

        $council_id = $request->get('council_id');

        $persons = Person::search($name, $council_id);

        return response()->json($persons);
    }

    public function attendanceReport(Request $request)
    {
        $date_filter = $request->get('date_filter');
        $filter_option = $request->get('filter_option');

        if (!$date_filter) {
            $date_filter = date("Y-m-d");
        }

        if (!$filter_option) {
            $filter_option = 'show_all';
        }

        $allPersons = Person::getAllPerson();
        $formStatus = ToggleForm::first();

        return view('results')
            ->with('date', $date_filter)
            ->with('filter_option', $filter_option)
            ->with('formStatus', $formStatus)
            ->with('allPersons', $allPersons);
    }

    public function toggleForm(Request $request)
    {

        ToggleForm::toggleForm();
        return response()->json(['state' => true]);
    }

    public function exportAttendance(Request $request)
    {

        $filter_option = $request->get('filter_option');
        $date = $request->get('date_filter');

        $exportAttendance = new ExportAttendance($date, $filter_option);

        return Excel::download($exportAttendance, "AA_Attendance_$date.xlsx");
    }
}
