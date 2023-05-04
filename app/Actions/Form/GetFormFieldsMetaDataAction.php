<?php

namespace App\Actions\Form;

use App\Models\Form;

class GetFormFieldsMetaDataAction
{
    public function execute()
    {
        $form = new Form();
        return $form->getFields();
    }
}
