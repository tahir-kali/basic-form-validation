<?php

namespace App\Http\Controllers;
use App\Actions\Form\GetFormFieldsMetaDataAction;
use App\Http\Requests\Form\StoreRequest;
use App\Models\Form;

class FormValidationController extends Controller
{
    public function show(GetFormFieldsMetaDataAction $action)
    {
        $success = session('success');
        $data = $action->execute();
        $form = new Form();
        $form1 = $form->getFormMetaData(1);
        $form2 = $form->getFormMetaData(2);

        return view('form', compact('data','form1','form2','success'));
    }

    public function store(StoreRequest $request)
    {

        $success = "Form passes all the validations successfully!";
        return redirect()->route('form.show')->with('success', $success);
    }

}
