<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Council;
use App\Person;
use App\Shepherd;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CouncilAttendanceController extends Controller
{
    //
    public function getCouncilForm($id)
    {
        $council = Council::find($id);

        //if we dont get council, we are screewed ...
        return view('council-data')
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
        $council_id = $request->get('council_id');
        $person_id = $request->get('person_id');
        $branch_id = $request->get('branch');

        $shepherd = Shepherd::search($search, $council_id, $branch_id, $person_id);

        return response()->json($shepherd);
    }
}
