<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    protected $table = 'council_branches';

    public function councilAttendance($date)
    {
    }

    public static function searchBranch($council_id, $searchTerm)
    {
        $branches = Branch::where('council_id', $council_id)
            ->where('branch_name', 'LIKE', '%' . $searchTerm . '%')
            ->select(['id', 'branch_name as text'])->get();

        return $branches;
    }
}
