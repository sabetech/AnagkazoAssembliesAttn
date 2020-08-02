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
        if ($council_id == 5) {
            return self::getOfaakorBranches($searchTerm);
        }

        $branches = Branch::where('council_id', $council_id)
            ->where('branch_name', 'LIKE', '%' . $searchTerm . '%')
            ->select(['id', 'branch_name as text'])->get();

        return $branches;
    }

    public static function getOfaakorBranches($search)
    {
        return Council::where('id', '>=', 10)
            ->where('council', 'LIKE', '%' . $search . '%')
            ->select(['id', 'council as text'])->get();
    }

    public function persons()
    {
        return $this->hasMany("\App\Person", 'branch_id', 'id');
    }

    public function shepherds()
    {
        return $this->hasMany('App\Shepherd', 'branch_id', 'id');
    }

    public function getPastorsFlowRatio($date)
    {
        $pastorsWhoFlowed = CouncilAttendance::where('council_attendance.branch_id', $this->id)
            ->join('persons', 'persons.id', '=', 'council_attendance.person_id')
            ->where('persons.rank', 'Pastor')
            ->where('council_attendance.date_taken', $date)
            ->get();

        $totalPastors = $this->persons()->where('rank', '=', 'Pastor')->count();

        return $pastorsWhoFlowed->count() . ' / ' . $totalPastors;
    }

    public function getMinisterShepheredFlowRatio($date)
    {
        $ministerShepherdsWhoFlowed = CouncilAttendance::where('council_attendance.branch_id', $this->id)
            ->join('persons', 'persons.id', '=', 'council_attendance.person_id')
            ->where('persons.rank', 'Minister Shepherd')
            ->where('date_taken', $date)
            ->get();

        $totalMinisterShepherds = $this->persons()->where('rank', '=', 'Minister Shepherd')->count();

        return $ministerShepherdsWhoFlowed->count() . ' / ' . $totalMinisterShepherds;
    }

    public function getGWOwhoFlowed($date)
    {
        $gwoWhoFlowed = CouncilAttendance::where('council_attendance.branch_id', $this->id)
            ->join('persons', 'persons.id', '=', 'council_attendance.person_id')
            ->where('persons.rank', 'GWO')
            ->where('date_taken', $date)
            ->get();

        $totalMinisterShepherds = $this->persons()->where('rank', '=', 'GWO')->count();

        return $gwoWhoFlowed->count() . '/' . $totalMinisterShepherds;
    }

    public function getShepherdsWhoFlowed($date)
    {
        $totalShepherdsWhoFlowed = 0;
        $shepherdsWhoFlowed = CouncilAttendance::where('council_attendance.branch_id', $this->id)
            ->where('date_taken', $date)->get();

        foreach ($shepherdsWhoFlowed as $shepherdsRow) {
            if ($shepherdsRow->shepherd_attendance_ids != 'null') {
                $totalShepherdsWhoFlowed += count(json_decode($shepherdsRow->shepherd_attendance_ids));
            }
        }
        return $totalShepherdsWhoFlowed;
    }

    public function getTotalShepherds()
    {
        return $this->shepherds->count();
    }

    public function getTotalMembersWhoFlowed($date)
    {
        $membersWhoFlowed = CouncilAttendance::where('date_taken', $date)
            ->where('branch_id', $this->id)
            ->sum('total_member_attendances');

        return $membersWhoFlowed . '/' . $this->membership_avg;
    }
}
