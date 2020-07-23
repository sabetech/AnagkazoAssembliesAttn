<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shepherd extends Model
{
    //
    protected $table = 'shepherds';
    protected $guarded = ['id'];

    public static function search($search, $branch_id, $person_id)
    {
        $shepherds = Shepherd::where('shepherd_name', 'LIKE', '%' . $search . '%');



        if (Shepherd::where('branch_id', $branch_id)->count() > 0) {
            $shepherds = $shepherds->where('branch_id', $branch_id);
        }

        if (Shepherd::where('person_id', $person_id)->count() > 0) {
            $shepherds = $shepherds->where('person_id', $person_id);
        }

        $shepherds = $shepherds->select(['id', 'shepherd_name as text'])->get();

        return $shepherds;
    }
}
