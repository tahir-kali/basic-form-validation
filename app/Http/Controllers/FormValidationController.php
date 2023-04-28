<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Http\Requests\Form\StoreRequest;
use Illuminate\Http\Request;

class FormValidationController extends Controller
{

    public function show()
    {
        return view('form')->with('data', Form::FIELDS['data']);
    }

    public function store(StoreRequest $request)
    {
        //        Do some action here
        return redirect(route('form.show'))->with('success', 'Form Passes all the validation rules!');
    }

}
