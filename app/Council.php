<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Council extends Model
{
    //
    protected $table = 'councils';
    protected $guarded = ['id'];

    public function persons()
    {
        return $this->hasMany('App\Person');
    }

    public function branches()
    {
        return $this->hasMany('App\Branch', 'council_id', 'id');
    }

    public function shepherds()
    {
        return $this->hasMany('App\Shepherd', 'council_id', 'id');
    }

    public static function search($council)
    {

        $councils_result = Council::where('council', 'LIKE', '%' . $council . '%')->select(['id', 'council as text'])->take(20)->get();

        return $councils_result;
    }

    public function getTotalPastors()
    {
        return $this->join('persons', 'persons.council_id', '=', 'councils.id')
            ->where('persons.rank', 'Pastor')
            ->where('persons.council_id', $this->id)->get();
    }

    public function getTotalMinisterShepherds()
    {
        return $this->join('persons', 'persons.council_id', '=', 'councils.id')
            ->where('persons.rank', 'Minister Shepherd')
            ->where('persons.council_id', $this->id)->get();
    }

    public function getTotalGWOs()
    {
        return $this->join('persons', 'persons.council_id', '=', 'councils.id')
            ->where('persons.rank', 'GWO')
            ->where('persons.council_id', $this->id)->get();
    }

    public function getCenterLeaders()
    {
        return $this->join('persons', 'persons.council_id', '=', 'councils.id')
            ->where('persons.rank', 'Center Overseer')
            ->where('persons.council_id', $this->id)->get();
    }

    public function getTotalShepherds()
    {
        return $this->shepherds;
    }

    public function getTotalMembersAvg()
    {
        return $this->branches->sum('membership_avg');
    }

    public function getPastorsWhoFlowed($date)
    {
        $pastorsWhoFlowed = CouncilAttendance::where('council_attendance.council_id', $this->id)
            ->join('persons', 'persons.id', '=', 'council_attendance.person_id')
            ->where('persons.rank', 'Pastor')
            ->where('council_attendance.date_taken', $date)
            ->get();

        return $pastorsWhoFlowed;
    }

    public function getMinisterShepherdsWhoFlowed($date)
    {
        $ministerShepherdsWhoFlowed = CouncilAttendance::where('council_attendance.council_id', $this->id)
            ->join('persons', 'persons.id', '=', 'council_attendance.person_id')
            ->where('persons.rank', 'Minister Shepherd')
            ->where('date_taken', $date)
            ->get();

        return $ministerShepherdsWhoFlowed;
    }

    public function getGWOwhoFlowed($date)
    {
        $gwoWhoFlowed = CouncilAttendance::where('council_attendance.council_id', $this->id)
            ->join('persons', 'persons.id', '=', 'council_attendance.person_id')
            ->where('persons.rank', 'GWO')
            ->where('date_taken', $date)
            ->get();

        return $gwoWhoFlowed;
    }

    public function getCenterLeadersWhoFlowed($date)
    {
        $centerLeadersWhoFlowed = CouncilAttendance::where('council_attendance.council_id', $this->id)
            ->join('persons', 'persons.id', '=', 'council_attendance.person_id')
            ->where('persons.rank', 'Center Overseer')
            ->where('date_taken', $date)
            ->get();

        return $centerLeadersWhoFlowed;
    }

    public function getShepherdsWhoFlowed($date)
    {
        $totalShepherdsWhoFlowed = [];
        $shepherdsWhoFlowed = CouncilAttendance::where('council_attendance.council_id', $this->id)
            ->where('date_taken', $date)->get();

        //make sure to get unique ids ..

        foreach ($shepherdsWhoFlowed as $shepherdsRow) {
            if ($shepherdsRow->shepherd_attendance_ids != 'null') {
                $totalShepherdsWhoFlowed = array_merge($totalShepherdsWhoFlowed, json_decode($shepherdsRow->shepherd_attendance_ids, true));
            }
        }
        return array_unique($totalShepherdsWhoFlowed);
    }

    public function getDefaultingPastors($date)
    {
        foreach ($this->persons as $person) {
        }
    }

    public function getDefaultingShepherds($date)
    {
        foreach ($this->shepherds as $shepherd) {
        }

        //$shepherdsWhoFlowed
    }

    public function getTotalMembersWhoFlowed($date)
    {
        $membersWhoFlowed = CouncilAttendance::where('date_taken', $date)
            ->where('council_id', $this->id)
            ->sum('total_member_attendances');

        return $membersWhoFlowed;
    }


    public function getPastorsFlowRatio($date)
    {
        if ($this->getTotalPastors()->count() == 0) return 'N/a';
        return $this->getPastorsWhoFlowed($date)->count() . "/" . $this->getTotalPastors()->count();
    }

    public function getMinisterShepheredFlowRatio($date)
    {
        if ($this->getTotalMinisterShepherds()->count() == 0) return 'N/a';
        return $this->getMinisterShepherdsWhoFlowed($date)->count() . "/" . $this->getTotalMinisterShepherds()->count();
    }

    public function getGWO_FlowRatio($date)
    {
        if ($this->getTotalGWOs()->count() == 0) return 'N/a';
        return $this->getGWOwhoFlowed($date)->count() . "/" . $this->getTotalGWOs()->count();
    }
}
