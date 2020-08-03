<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Council;
use App\CouncilAttendance;
use App\Exports\ExportCouncilData;
use App\Ofaakor;
use App\Person;
use App\Shepherd;
use App\ToggleForm;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CouncilAttendanceController extends Controller
{
    //
    public function getCouncilForm($id)
    {
        $council = Council::find($id);
        $formStatus = ToggleForm::where('id', 2)->first();

        //if we dont get council, we are screewed ...
        return view('council-data')
            ->with('formStatus', $formStatus)
            ->with('council', $council);
    }



    public function getBranches(Request $request)
    {
        $council_id = $request->get('council_id');
        $search = $request->get('search');

        $branches = Branch::searchBranch($council_id, $search);

        return response()->json($branches);
    }

    public function getPastors(Request $request)
    {
        $search = $request->get('search');
        $council_id = $request->get('council_id');
        $rank = $request->get('rank');
        $branch = $request->get('branch');

        $person = Person::search($search, $council_id, $branch, $rank);

        return response()->json($person);
    }

    public function getShepherds(Request $request)
    {
        $search = $request->get('search');
        $person_id = $request->get('person_id');
        $branch_id = $request->get('branch');

        $shepherd = Shepherd::search($search, $branch_id, $person_id);

        return response()->json($shepherd);
    }

    public function postCouncilAttendance(Request $request)
    {
        $date_taken = $request->get('date');
        $person_id = $request->get('person_name');
        $shepherds = $request->get('pastors-shepherds');
        $member_count = $request->get('flow_member_attendance', 0);
        $branch_id = $request->get('mission');
        $council_id = $request->get('council_id');

        $person = Person::find($person_id);
        if ($council_id == 5 && ($branch_id != 1000)) { // if the council is ofaakor
            $council_id = $branch_id;
            $branch_id = $request->get('mission-branch');
        }

        if ($branch_id == 1000) { //this is nsakina ...
            $branch_id = 163;
        }


        $branch = Branch::find($branch_id);
        $council = Council::find($council_id);

        CouncilAttendance::updateOrCreate(
            [
                'date_taken' => $date_taken,
                'person_id' => $person_id
            ],
            [
                'council_id' => $council->id,
                'branch_id' => $branch->id,
                'shepherd_attendance_ids' => json_encode($shepherds),
                'total_member_attendances' => ($member_count) ? $member_count : 0
            ]
        );

        return view('attendance_submit')
            ->with('date', $date_taken)
            ->with('msg', 'Your FLOW attendance information has been recorded Successfully!')
            ->with('branch', $branch)
            ->with('council', $council)
            ->with('person', $person);
    }

    public function report(Request $request)
    {
        $date = $request->get('date_filter', date("Y-m-d"));

        //get All councils and get all get council reports
        $councils = Council::all();
        $formStatus = ToggleForm::where('id', 1)->first();

        return view('council_reports')
            ->with('councils', $councils)
            ->with('formStatus', $formStatus)
            ->with('page_title', "Council FLOW Report")
            ->with('date', $date);
    }

    public function toggleForm(Request $request)
    {
        ToggleForm::toggleForm(2);
        return response()->json(['state' => true]);
    }

    public function export(Request $request)
    {
        $date = $request->get('date_filter');

        $exportCouncilAttendance = new ExportCouncilData($date);
        return Excel::download($exportCouncilAttendance, "AA_COUNCIL_ATTENANCE_{$date}.xlsx");
    }

    public function verify_submission(Request $request)
    {
    }

    public function defaulters(Request $request)
    {

        $date = $request->get('date');
        $councils = Council::all();

        foreach ($councils as $council) {

            // $persons

        }
    }

    public function getMission_branch(Request $request)
    {
        $searchTerm = $request->get('search');
        $branch_id = $request->get('branch_id');

        $branches = Ofaakor::$missions_branches[$branch_id];

        return json_encode($branches);
    }
}
