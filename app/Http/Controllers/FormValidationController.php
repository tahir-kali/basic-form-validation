<?php

namespace App\Http\Controllers;
use App\Contracts\FormValidationControllerContractor;
use App\Http\Requests\Form\StoreRequest;
use App\Models\Field;
use App\Models\Form;
use App\Providers\FileServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class FormValidationController extends Controller implements FormValidationControllerContractor
{
    public function show(): View
    {
        $success = session('success');
        $form = new Form();
        $data = Field::getFields();
        $form1 = $form->getFormMetaData(1);
        $form2 = $form->getFormMetaData(2);
        return view('form', compact('data','form1','form2','success'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $success = "Form passes all the validations successfully!";
        return redirect()->route('form.show')->with('success', $success);
    }

}
