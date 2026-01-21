<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\AuthController;



Route::get('/', function () {
    return view('welcome');
});

// переписать на ресурсные роуты
Route::get('/things', [ThingController::class, 'index'])->name('index');
Route::get('/things/create', [ThingController::class, 'create']);
Route::post('/things', [ThingController::class, 'store']);


Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');



