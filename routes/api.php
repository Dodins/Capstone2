<?php

use App\Http\Controllers\Admin\AuthAdminController;
use App\Http\Controllers\Resident\AuthResidentController;
use App\Http\Middleware\CheckIfResident;
use App\Http\Middleware\CheckIfVerifiedResident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthResidentController::class, 'authenticate']);
Route::post('/register', [AuthResidentController::class, 'store']);


// RESIDENT
Route::middleware(['auth:sanctum', CheckIfResident::class])->group(function () {



});

// VERIFIED RESIDENT
Route::middleware(['auth:sanctum', CheckIfVerifiedResident::class])->group(function () {

    Route::post('/logout', [AuthResidentController::class, 'destroy']);


    //TEST GET REQUEST
    Route::get('/test', function(){
        return ['message' =>  'This is working'];
    });
});










// WEB TESTING
Route::middleware(['auth', 'web'])->group(function () {




});

