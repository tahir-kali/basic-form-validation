<?php

namespace App\Actions\Form;

use App\Models\Form;

class GetForm2Action
{
    public function execute()
    {
        return Form::getForm2();
    }
}
