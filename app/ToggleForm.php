<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToggleForm extends Model
{
    //
    protected $table = 'toggle_form';

    public static function toggleForm($id)
    {
        $existingState = ToggleForm::where('id', $id)->first();
        ToggleForm::where('id', $id)->update(['form_status' => !$existingState->form_status]);
    }
}
