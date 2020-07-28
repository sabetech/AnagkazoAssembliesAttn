<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Council;
use App\CouncilAttendance;
use App\Person;
use App\Shepherd;
use App\ToggleForm;
use Illuminate\Http\Request;

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
}
