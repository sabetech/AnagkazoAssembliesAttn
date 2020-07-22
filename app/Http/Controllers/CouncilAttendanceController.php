<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CouncilAttendanceController extends Controller
{
    //
    public function ofaakor(Request $request)
    {
        return view('council-data')
            ->with('council_name', 'Ofaakor');
    }

    public function getMissions(Request $request)
    {
        $council_id = $request->get('council_id');

        $data = new Collection([
            ['id' => 1, 'data' => 'Bouake'],
            ['id' => 2, 'data' => 'Another Option']
        ]);

        return response()->json($data);
    }
}
