<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shepherd extends Model
{
    //
    protected $table = 'shepherds';
    protected $guarded = ['id'];

    public static function search($search, $council_id, $branch_id, $person_id)
    {
        $shepherds = Shepherd::where('shepherd_name', 'LIKE', '%' . $search . '%')->select(['id', 'shepherd_name as text'])->get();
        return $shepherds;
    }
}
