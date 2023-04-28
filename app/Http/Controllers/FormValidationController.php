<?php

namespace App\Http\Controllers;

use App\Actions\Form\GetFormFieldsMetaDataAction;
use App\Models\Form;
use App\Http\Requests\Form\StoreRequest;
use Illuminate\Http\Request;

class FormValidationController extends Controller
{

    public function show(GetFormFieldsMetaDataAction $action)
    {
        return view('form')->with('data', $action->execute());
    }

    public function store(StoreRequest $request)
    {
        //        Do some action here
        return redirect(route('form.show'))->with('success', 'Form Passes all the validation rules!');
    }

}
