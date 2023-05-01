<?php

namespace App\Http\Controllers;

use App\Actions\Form\GetForm1Action;
use App\Actions\Form\GetForm2Action;
use App\Actions\Form\GetFormFieldsMetaDataAction;
use App\Http\Requests\Form\StoreRequest;

class FormValidationController extends Controller
{

    public function show(GetFormFieldsMetaDataAction $action, GetForm1Action $form1Action, GetForm2Action $form2Action)
    {
        $data = $action->execute();
        $form1 = $form1Action->execute();
        $form2 = $form2Action->execute();
        return view('form', compact('data','form1','form2'));
    }

    public function storeForm1(StoreRequest $request)
    {
        $success = "Form passes all the validations successfully!";
        return redirect()->route('form.show')->with('success', $success);
    }
    public function storeForm2(StoreRequest $request)
    {
        $success = "Form passes all the validations successfully!";
        return redirect()->route('form.show')->with('success', $success);
    }

}
