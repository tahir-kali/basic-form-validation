<?php

namespace App\Actions\Form;

use App\Models\Form;

class ForceFormRequestFieldsAction
{
    public function execute($formName)
    {
        return $this->constructFillables($formName === "form1" ? Form::getForm1():Form::getForm2());
    }
    public function constructFillables($form){
        $fillable = [];
        foreach($form as $field){
                array_push($fillable,$field);
        }
        return $fillable;
    }
}
