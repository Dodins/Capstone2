<?php

use App\Http\Middleware\CheckIfAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Admin\VerificationAdminController;
use App\Http\Controllers\Admin\AnnouncementAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\MapAdminController;
use App\Http\Controllers\Admin\EventAdminController;
use App\Http\Controllers\Admin\ConcernDisplayAdminController;
use App\Http\Controllers\Admin\ConcernAdminController;

Route::get('/', function () {
    return Inertia::render('Landing');
});

Route::get('register', [AuthAdminController::class, 'register'])->name('register');
Route::get('login', [AuthAdminController::class, 'login'])->name('login');

Route::post('register', [AuthAdminController::class, 'store'])->name('store');
Route::post('login', [AuthAdminController::class, 'authenticate'])->name('authenticate');

// ADMIN MIDDLEWARE
Route::middleware(['auth', CheckIfAdmin::class])->group(function () {

    Route::post('logout', [AuthAdminController::class, 'logout'])->name('logout');

    // ----------------- DASHBOARD ----------------- //
    Route::get('/dashboard', [DashboardAdminController::class, 'dashboard'])->name('dashboard');


    // ----------------- CONCERN ----------------- //
    Route::get('/incoming-reports', [ConcernDisplayAdminController::class, 'incomingReports'])->name('incomingReports');
    Route::get('/high-priority-reports', [ConcernDisplayAdminController::class, 'highPriorityReports'])->name('highPriorityReports');
    Route::get('/medium-priority-reports', [ConcernDisplayAdminController::class, 'mediumPriorityReports'])->name('mediumPriorityReports');
    Route::get('/low-priority-reports', [ConcernDisplayAdminController::class, 'lowPriorityReports'])->name('lowPriorityReports');
    Route::post('/set-priority/{id}', [ConcernAdminController::class, 'setPriority'])->name('setPriority');
    Route::delete('/reject/{id}', [ConcernAdminController::class, 'reject'])->name('rejectIncomingReports');
    Route::post('/update-status/{id}', [ConcernAdminController::class, 'updateStatus'])->name('updateStatus');


    // ----------------- CALENDAR ----------------- //
    Route::get('/calendar', [EventAdminController::class, 'calendar'])->name('calendar');
    Route::get('/calendar/create', [EventAdminController::class, 'createEvent'])->name('calendar.create');
    Route::post('/calendar/create', [EventAdminController::class, 'store'])->name('calendar.store');
    Route::get('/calendar/edit/{id}', [EventAdminController::class, 'updateEvent'])->name('calendar.edit');
    Route::post('/calendar/edit/{id}', [EventAdminController::class, 'update'])->name('calendar.update');
    Route::delete('/calendar/destroy/{id}', [EventAdminController::class, 'destroy'])->name('calendar.destroy');


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
