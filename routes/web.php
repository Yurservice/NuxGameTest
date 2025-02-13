<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [MainController::class, 'showForm'])->name('register.form');
Route::post('/register', [MainController::class, 'register'])->name('register');
Route::get('/page/{uniqueLink}', [MainController::class, 'accessPage'])->name('access.page');
Route::get('/success', function () {
    return view('success');
})->name('success');
