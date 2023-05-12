<?php
//▄▄▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄▄▄ ▄         ▄ ▄▄▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄▄▄            ▄▄▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄  ▄▄▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄▄▄
//▐░░░░░░░░░░░▐░░░░░░░░░░░▐░▌       ▐░▐░░░░░░░░░░░▐░░░░░░░░░░░▌          ▐░░░░░░░░░░░▌▐░░░░░░░░░▌▐░░░░░░░░░░░▐░░░░░░░░░░░▌
// ▀▀▀▀█░█▀▀▀▀▐░█▀▀▀▀▀▀▀█░▐░▌       ▐░▌▀▀▀▀█░█▀▀▀▀▐░█▀▀▀▀▀▀▀█░▌           ▀▀▀▀▀▀▀▀▀█░▐░█░█▀▀▀▀▀█░▌▀▀▀▀▀▀▀▀▀█░▌▀▀▀▀▀▀▀▀▀█░▌
//     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▌    ▐░▌    ▐░▌       ▐░▌                    ▐░▐░▌▐░▌    ▐░▌         ▐░▌         ▐░▌
//     ▐░▌    ▐░█▄▄▄▄▄▄▄█░▐░█▄▄▄▄▄▄▄█░▌    ▐░▌    ▐░█▄▄▄▄▄▄▄█░▌                    ▐░▐░▌ ▐░▌   ▐░▌         ▐░▌▄▄▄▄▄▄▄▄▄█░▌
//     ▐░▌    ▐░░░░░░░░░░░▐░░░░░░░░░░░▌    ▐░▌    ▐░░░░░░░░░░░▌           ▄▄▄▄▄▄▄▄▄█░▐░▌  ▐░▌  ▐░▌▄▄▄▄▄▄▄▄▄█░▐░░░░░░░░░░░▌
//     ▐░▌    ▐░█▀▀▀▀▀▀▀█░▐░█▀▀▀▀▀▀▀█░▌    ▐░▌    ▐░█▀▀▀▀█░█▀▀           ▐░░░░░░░░░░░▐░▌   ▐░▌ ▐░▐░░░░░░░░░░░▌▀▀▀▀▀▀▀▀▀█░▌
//     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▌    ▐░▌    ▐░▌     ▐░▌            ▐░█▀▀▀▀▀▀▀▀▀▐░▌    ▐░▌▐░▐░█▀▀▀▀▀▀▀▀▀          ▐░▌
//     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▌▄▄▄▄█░█▄▄▄▄▐░▌      ▐░▌           ▐░█▄▄▄▄▄▄▄▄▄▐░█▄▄▄▄▄█░█░▐░█▄▄▄▄▄▄▄▄▄ ▄▄▄▄▄▄▄▄▄█░▌
//     ▐░▌    ▐░▌       ▐░▐░▌       ▐░▐░░░░░░░░░░░▐░▌       ▐░▌          ▐░░░░░░░░░░░▌▐░░░░░░░░░▌▐░░░░░░░░░░░▐░░░░░░░░░░░▌
//      ▀      ▀         ▀ ▀         ▀ ▀▀▀▀▀▀▀▀▀▀▀ ▀         ▀            ▀▀▀▀▀▀▀▀▀▀▀  ▀▀▀▀▀▀▀▀▀  ▀▀▀▀▀▀▀▀▀▀▀ ▀▀▀▀▀▀▀▀▀▀▀

namespace App\Http\Controllers;

use App\Actions\GetFormsAction;
use App\Contracts\FormValidationControllerContractor;
use App\Http\Requests\Form\StoreRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class FormValidationController extends Controller implements FormValidationControllerContractor
{
    public function show(GetFormsAction $action): View
    {
        $result = $action->execute();
        $success = session('success');
        $data    = $result['fields'];
        $form1   = $result['form1'];
        $form2   = $result['form2'];

        return view('form', compact('data', 'form1', 'form2', 'success'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $success = "Form passes all the validations successfully!";
        return redirect()->route('form.show')->with('success', $success);
    }

}
