<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormValidationController;

Route::middleware(['guest'])->group(function () {
    Route::post('/form-validation/form1', [FormValidationController::class, 'storeForm1'])->name('form.storeForm1');
    Route::post('/form-validation/form2', [FormValidationController::class, 'storeForm2'])->name('form.storeForm2');
});
