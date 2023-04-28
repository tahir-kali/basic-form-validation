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


Route::get('/', [FormValidationController::class, 'show'])->name('form.show');
Route::post('/store', [FormValidationController::class, 'store'])->name('form.store');
