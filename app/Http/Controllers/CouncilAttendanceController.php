<?php

namespace App\Http\Controllers;

use App\Council;
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
            ->with('council_name', $council->council);
    }



    public function getBranches(Request $request)
    {
        $council_id = $request->get('council_id');

        $data = new Collection([
            ['id' => 1, 'text' => 'Bouake'],
            ['id' => 2, 'text' => 'Another Option']
        ]);

        return response()->json($data);
    }
}
