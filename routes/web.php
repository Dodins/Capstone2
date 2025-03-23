<?php

use App\Http\Middleware\CheckIfAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\VerificationAdminController;
use App\Http\Controllers\Admin\AnnouncementAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\MapAdminController;

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
    Route::get('/calendar', function () {
        return Inertia::render('Calendar');
    })->name('calendar');

    Route::post('logout', [AuthAdminController::class, 'logout'])->name('logout');

    // ----------------- DASHBOARD ----------------- //
    Route::get('/dashboard', [DashboardAdminController::class, 'dashboard'])->name('dashboard');


    // ----------------- MAP ----------------- //
    Route::get('/map', [MapAdminController::class, 'map'])->name('map');
    Route::post('/map', [MapAdminController::class, 'store'])->name('map.store');
    Route::delete('/map/{id}', [MapAdminController::class, 'destroy'])->name('map.destroy');


    // ----------------- ANNOUNCEMENT ----------------- //
    Route::get('/announcement', [AnnouncementAdminController::class, 'index'])->name('announcement');
    Route::get('/announcement/create', [AnnouncementAdminController::class, 'createAnnouncement'])->name('announcement.create');
    Route::post('/announcement/create', [AnnouncementAdminController::class, 'store'])->name('announcement.store');
    Route::get('/announcement/edit/{id}', [AnnouncementAdminController::class, 'editAnnouncement'])->name('announcement.edit');
    Route::post('/announcement/edit/{id}', [AnnouncementAdminController::class, 'update'])->name('announcement.update');
    Route::delete('/announcement/destroy/{id}', [AnnouncementAdminController::class, 'destroy'])->name('announcement.destroy');


    // ----------------- VERIFICATION OF USER ----------------- //
    Route::get('/verification', [VerificationAdminController::class, 'verification'])->name('verification');
    Route::put('/accept-verification/{id}/accept', [VerificationAdminController::class, 'accept'])->name('acceptVerification');
    Route::put('/reject-verification/{id}/reject', [VerificationAdminController::class, 'reject'])->name('rejectVerification');
});
