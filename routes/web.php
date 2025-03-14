<?php

use App\Http\Middleware\CheckIfAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Admin\AuthAdminController;

Route::get('/', function () {
    return Inertia::render('Landing');
});

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->name('register');


Route::post('register', [AuthAdminController::class, 'store'])->name('register');
Route::post('login', [AuthAdminController::class, 'authenticate'])->name('login');

// ADMIN MIDDLEWARE
Route::middleware(['auth', CheckIfAdmin::class])->group(function () {

    // ----------------- NAVIGATION ----------------- //
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/verification', function () {
        return Inertia::render('UserVerification');
    })->name('verification');




    Route::post('logout', [AuthAdminController::class, 'logout'])
        ->name('logout');
});

