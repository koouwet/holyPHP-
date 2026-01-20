<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/things', [ThingController::class, 'index']);
