<?php

namespace App\Actions\Form;

use App\Models\Form;

class GetForm1Action
{
    public function execute()
    {
        return Form::getForm1();
    }
}
