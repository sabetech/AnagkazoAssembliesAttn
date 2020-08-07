<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Attendance;

class Person extends Model
{
    //
    protected $table = "persons";
    protected $guarded = ['id'];

    public function Council()
    {
        return $this->belongsTo('App\Council');
    }

    public function Branch()
    {
        return $this->belongsTo('App\Branch', 'branch_id', 'id');
    }

    public static function search($name, $council_id = '', $branch_id = '', $rank = '')
    {
        if ($council_id == 5) {
            $persons_result = Person::where('name', 'LIKE', '%' . $name . '%');
        } else {
            $persons_result = Person::where('name', 'LIKE', '%' . $name . '%')
                ->where('councils.id', 'LIKE', $council_id);
        }


        if ($branch_id != '')
            $persons_result = $persons_result->where('branch_id', 'LIKE', $branch_id);

        if ($rank != '')
            $persons_result = $persons_result->where('rank', 'LIKE', $rank);

        $persons_result = $persons_result->leftJoin('councils', 'councils.id', '=', 'persons.council_id')
            ->select(['persons.id', 'name as text'])->get();

        return $persons_result;
    }

    public static function getAllPerson()
    {
        $persons = Person::orderBy('council_id', 'asc')->get();
        return $persons;
    }

    public function wasPresent($date)
    {

        $person = Attendance::where('date_taken', $date)
            ->where('person_id', $this->id)
            ->first();
        if ($person)
            return true;
        return false;
    }

    public function tvOrOnline($date)
    {
        $person = Attendance::where('date_taken', $date)
            ->where('person_id', $this->id)
            ->first();
        if ($person)
            return $person->flow_option;
        return 'none';
    }

    public function wasPresent_council($date)
    {
        $person = CouncilAttendance::where('date_taken', $date)
            ->where('person_id', $this->id)
            ->first();

        if ($person)
            return 'YES';
        return 'NO';
    }

    public function getNumberOfShepherdsPresent($date)
    {
        $shepherds = CouncilAttendance::where('date_taken', $date)
            ->where('person_id', $this->id)
            ->first();

        if (!$shepherds) return '0';

        if ($shepherds->shepherd_attendance_ids != 'null')
            return count(json_decode($shepherds->shepherd_attendance_ids));
        return '0';
    }

    public function getShepherdsPresent($date)
    {
        $shepherds = CouncilAttendance::where('date_taken', $date)
            ->where('person_id', $this->id)
            ->first();

        if (!$shepherds) return [];
        if (!$shepherds->shepherd_attendance_ids) return [];

        if (!is_null($shepherds->shepherd_attendance_ids))
            return json_decode($shepherds->shepherd_attendance_ids, true);
    }

    public function getNumberOfMembersPresent($date)
    {

        $numberOfMembers = CouncilAttendance::where('date_taken', $date)
            ->where('person_id', $this->id)
            ->first();

        if ($numberOfMembers)
            return $numberOfMembers->total_member_attendances;
        return '0';
    }
}
