<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    protected $table = "persons";
    protected $guarded = ['id'];

    public static function search($name, $council_id = ''){

        $persons_result = Person::where('name', 'LIKE', '%'.$name.'%')
                                ->where('councils.id', 'LIKE', $council_id)
                                ->leftJoin('councils', 'councils.id','=','persons.council_id')
                                ->select(['persons.id', 'name as text'])->take(20)->get();

        return $persons_result;

    }
}
