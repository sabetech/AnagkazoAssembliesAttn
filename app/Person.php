<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Attendance;
class Person extends Model
{
    //
    protected $table = "persons";
    protected $guarded = ['id'];

    public function Council(){
        return $this->belongsTo('App\Council');
    }

    public static function search($name, $council_id = ''){

        $persons_result = Person::where('name', 'LIKE', '%'.$name.'%')
                                ->where('councils.id', 'LIKE', $council_id)
                                ->leftJoin('councils', 'councils.id','=','persons.council_id')
                                ->select(['persons.id', 'name as text'])->get();

        return $persons_result;

    }

    public static function getAllPerson(){
        $persons = Person::all();
        return $persons;
    }

    public function wasPresent($date){

        $person = Attendance::where('date_taken', $date)
                    ->where('person_id', $this->id)
                    ->first();
        if ($person)
            return true;
        return false;

    }
}
