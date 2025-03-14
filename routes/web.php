<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Test');
});


Route::middleware(['auth', 'second'])->group(function () {

});
