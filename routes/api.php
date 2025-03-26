<?php

use App\Http\Controllers\Admin\ConcernAdminController;
use App\Http\Controllers\Admin\ConcernDisplayAdminController;
use App\Http\Controllers\Admin\NotificationAdminController;
use App\Http\Controllers\Admin\VerificationAdminController;
use App\Http\Controllers\Admin\SafetyTipsAdminController;
use App\Http\Controllers\Resident\AnnouncementResidentController;
use App\Http\Controllers\Resident\AuthResidentController;
use App\Http\Controllers\Resident\ConcernResidentController;
use App\Http\Controllers\Resident\VerificationResidentController;
use App\Http\Controllers\Resident\SafetyTipsController;
use App\Http\Middleware\CheckIfResident;
use App\Http\Middleware\CheckIfVerifiedResident;
use Illuminate\Support\Facades\Route;


// AUTHENTICATION
Route::post('/login', [AuthResidentController::class, 'authenticate']);
Route::post('/register', [AuthResidentController::class, 'store']);
Route::get('/check-token', [AuthResidentController::class, 'checkToken'])->middleware('auth:sanctum');

// PASSWORD RESET SYSTEM
Route::post('/forgot-password', [AuthResidentController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthResidentController::class, 'resetPassword']);

// RESIDENT
Route::middleware(['auth:sanctum', CheckIfResident::class])->group(function () {

    Route::get('/resident', [AuthResidentController::class, 'resident']);

    Route::post('/logout', [AuthResidentController::class, 'destroy']);
    Route::get('/announcements', [AnnouncementResidentController::class, 'index']);
    Route::post('/submit-verification', [VerificationResidentController::class, 'store']);
    Route::get('/existing-verification', [VerificationResidentController::class, 'index']);


    // For safety tips
    Route::get('/safety-tips', [SafetyTipsController::class, 'index']);
});

// VERIFIED RESIDENT
Route::middleware(['auth:sanctum', CheckIfVerifiedResident::class])->group(function () {

    //ROUTES FOR VERIFIED RESIDENT

    // CONCERN
    Route::apiResource('concerns', ConcernResidentController::class);
    Route::post('/concerns/resolvedToComplete/{id}', [ConcernResidentController::class, 'resolvedToComplete']);
    Route::post('/resolved/{id}', [ConcernResidentController::class, 'resolvedToComplete']);
});





// WEB TESTING
// NOTE SOME URL SAME WITH THE API ROUTE BUT IT WOULDNT AFFECT IF THIS WEB TESTING ROUTES IS NOW IN THE WEB PHP

// Route::resource('announcements', AnnouncementAdminController::class);
Route::post('/accept-verification/{id}/accept', [VerificationAdminController::class, 'accept']);
Route::post('/accept-verification/{id}/reject', [VerificationAdminController::class, 'reject']);
Route::get('/unverifiedResident', [VerificationAdminController::class, 'unverifiedResidents']);
Route::post('/change-status/{id}', [ConcernAdminController::class, 'updateStatus']);
Route::post('/set-priority/{id}', [ConcernAdminController::class, 'setPriority']);
Route::post('/reject/{id}', [ConcernAdminController::class, 'reject']);
Route::get('/concern-display/{priority}', [ConcernDisplayAdminController::class, 'priorityConcerns']);
Route::get('/incomingReports', [ConcernDisplayAdminController::class, 'incomingReports']);



//concern
Route::get('/low-priority-reports', [ConcernDisplayAdminController::class, 'lowPriorityReports']);


//NOTIFICATION
Route::get('/notification', [NotificationAdminController::class, 'notification']);
Route::post('/markAsRead', [NotificationAdminController::class, 'markAsRead']);
