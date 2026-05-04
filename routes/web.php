<?php

use App\Http\Controllers\PartController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('pages.welcome');
})->middleware('auth')->name('welcome');

Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', function () {
            return view('pages.admin.dashboard');
        })->name('dashboard');
       Route::resource('/users', UserController::class)->names('users');
       Route::resource('/vehicles', VehicleController::class)->names('vehicles');
       Route::resource('/parts', PartController::class)->names('parts');
       Route::resource('/reports', ReportController::class)->names('reports');
       Route::get('/parts/{part}/stock', [PartController::class, 'formStock'])->name('parts.stock');
       Route::post('/parts/{part}/add-stock', [PartController::class, 'addStock'])->name('parts.addStock');
       Route::post('/parts/{part}/reduce-stock', [PartController::class, 'reduceStock'])->name('parts.reduceStock');
    });
require __DIR__ . '/auth.php';
