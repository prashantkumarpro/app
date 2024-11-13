<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;

Route::get('/', function () {
    return view('welcome');
});


// Route to show the form
Route::get('/register', [FormController::class, 'showForm']);

// Route to handle form submission
Route::post('/form', [FormController::class, 'submitForm'])->name('register.submit');