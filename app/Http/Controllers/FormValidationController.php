<?php

namespace App\Http\Controllers;
use App\Contracts\FormValidationControllerContractor;
use App\Http\Requests\Form\StoreRequest;
use App\Models\Field;
use App\Models\Form;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class FormValidationController extends Controller implements FormValidationControllerContractor
{
    public function show(): View
    {
        $success = session('success');
        $form = new Form();
        $data = Field::getAll();
        $form1 = $form->getFormFields(1);
        $form2 = $form->getFormFields(2);
        return view('form', compact('data','form1','form2','success'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $success = "Form passes all the validations successfully!";
        return redirect()->route('form.show')->with('success', $success);
    }

}
