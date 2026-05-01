<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('pages.welcome');
})->middleware('auth')->name('welcome');

Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.admin.dashboard');
        })->name('dashboard');
       Route::resource('/users', UserController::class)->names('users');
    });
require __DIR__ . '/auth.php';
