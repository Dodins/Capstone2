<?php

use App\Http\Middleware\CheckIfAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\VerificationAdminController;
use App\Http\Controllers\Admin\AnnouncementAdminController;

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
    Route::get('/calendar', function () {
        return Inertia::render('Calendar');
    })->name('calendar');
    Route::get('/map', function () {
        return Inertia::render('MapMain');
    })->name('map');

    Route::post('logout', [AuthAdminController::class, 'logout'])->name('logout');


    // ----------------- ANNOUNCEMENT ----------------- //
    Route::get('/announcement', [AnnouncementAdminController::class, 'index'])->name('announcement');
    Route::get('/announcement/create', [AnnouncementAdminController::class, 'createAnnouncement'])->name('announcement.create');
    Route::post('/announcement/create', [AnnouncementAdminController::class, 'store'])->name('announcement.store');
    Route::get('/announcement/edit/{id}', [AnnouncementAdminController::class, 'editAnnouncement'])->name('announcement.edit');
    Route::post('/announcement/edit/{id}', [AnnouncementAdminController::class, 'update'])->name('announcement.update');
    Route::delete('/announcement/destroy/{id}', [AnnouncementAdminController::class, 'destroy'])->name('announcement.destroy');


    // ----------------- VERIFICATION OF USER ----------------- //
    Route::put('/accept-verification/{id}/accept', [VerificationAdminController::class, 'accept'])->name('acceptVerification');
    Route::put('/reject-verification/{id}/reject', [VerificationAdminController::class, 'reject'])->name('rejectVerification');
    Route::get('/unverifiedResident', [VerificationAdminController::class, 'unverifiedResidents'])->name('unverified.resident');
});
