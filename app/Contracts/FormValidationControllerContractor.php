<?php

namespace App\Contracts;

use App\Http\Requests\Form\StoreRequest;
use App\Providers\FileServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

interface FormValidationControllerContractor
{
    public function show(): View;

    public function store(StoreRequest $request): RedirectResponse;
}
