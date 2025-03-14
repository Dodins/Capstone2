<?php

use App\Http\Controllers\Resident\AnnouncementResidentController;
use App\Http\Controllers\Resident\AuthResidentController;
use App\Http\Middleware\CheckIfResident;
use App\Http\Middleware\CheckIfVerifiedResident;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthResidentController::class, 'authenticate']);
Route::post('/register', [AuthResidentController::class, 'store']);


// RESIDENT
Route::middleware(['auth:sanctum', CheckIfResident::class])->group(function () {

    Route::post('/logout', [AuthResidentController::class, 'destroy']);
    Route::get('/announcements', [AnnouncementResidentController::class,'index']);

});

// VERIFIED RESIDENT
Route::middleware(['auth:sanctum', CheckIfVerifiedResident::class])->group(function () {

    //ROUTES FOR VERIFIED RESIDENT

});





// WEB TESTING
// NOTE SOME URL SAME WITH THE API ROUTE BUT IT WOULDNT AFFECT IF THIS WEB TESTING ROUTES IS NOW IN THE WEB PHP

// Route::resource('announcements', AnnouncementAdminController::class);









