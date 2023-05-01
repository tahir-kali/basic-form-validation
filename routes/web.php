<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormValidationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(FormValidationController::class)
    ->middleware('guest')
    ->name('form.')
    ->group(function () {
        Route::get('/', 'show')->name('show');
        Route::post('/form1', 'storeForm1')->name('storeForm1');
        Route::post('/form2', 'storeForm2')->name('storeForm2');
    });
