<?php

namespace App\Actions\Form;

use App\Models\Form;

class GetFormFieldsMetaDataAction
{
    public function execute()
    {
        return Form::getFields();
    }
}
