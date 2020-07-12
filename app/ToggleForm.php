<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToggleForm extends Model
{
    //
    protected $table = 'toggle_form';

    public static function toggleForm(){
        $existingState = ToggleForm::first();
        ToggleForm::where('id',1)->update(['form_status' => !$existingState->form_status]);
    }
}
