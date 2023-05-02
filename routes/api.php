<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormValidationController;

Route::middleware(['guest'])->group(function () {
    Route::post('/form-validation/', [FormValidationController::class, 'store'])->name('form.store');
});
