<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Council extends Model
{
    //
    protected $table='councils';
    protected $guarded = ['id'];

    public static function search($council){

        $councils_result = Council::where('council', 'LIKE', '%'.$council.'%')->select(['id', 'council as text'])->take(20)->get();

        return $councils_result;

    }
}
