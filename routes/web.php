<?php

use App\Http\Middleware\CheckIfAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\ResidentAdminController;

Route::get('/', function () {
    return Inertia::render('Landing');
});




Route::get('register', [AuthAdminController::class, 'register'])->name('register');
Route::get('login', [AuthAdminController::class, 'login'])->name('login');

Route::post('register', [AuthAdminController::class, 'store'])->name('store');
Route::post('login', [AuthAdminController::class, 'authenticate'])->name('authenticate');

// ADMIN MIDDLEWARE
Route::middleware(['auth', CheckIfAdmin::class])->group(function () {

    // ----------------- NAVIGATION ----------------- //
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/verification', function () {
        return Inertia::render('UserVerification');
    })->name('verification');


    Route::get('verified-users', [ResidentAdminController::class, 'index'])->name('verified-users');

    Route::post('logout', [AuthAdminController::class, 'logout'])
        ->name('logout');
});

