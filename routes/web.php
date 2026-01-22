<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\UsageController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTH (WEB)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | ARCHIVE
    |--------------------------------------------------------------------------
    */
    Route::get('/archive', [ThingController::class, 'archive'])
        ->name('things.archive');

    Route::post('/archive/{id}/restore', [ThingController::class, 'restoreFromArchive'])
        ->name('things.archive.restore');

    /*
    |--------------------------------------------------------------------------
    | FILTERS
    |--------------------------------------------------------------------------
    */
    Route::get('/things/filter/my', [ThingController::class, 'listMy'])->name('things.filter.my');
    Route::get('/things/filter/repair', [ThingController::class, 'listRepair'])->name('things.filter.repair');
    Route::get('/things/filter/work', [ThingController::class, 'listWork'])->name('things.filter.work');
    Route::get('/things/filter/used', [ThingController::class, 'listUsed'])->name('things.filter.used');
    Route::get('/things/filter/all', [ThingController::class, 'listAll'])->name('things.filter.all');

    /*
    |--------------------------------------------------------------------------
    | RESOURCES
    |--------------------------------------------------------------------------
    */
    Route::resource('things', ThingController::class);
    Route::resource('places', PlaceController::class);
    Route::resource('usages', UsageController::class)->except(['show']);

    /*
    |--------------------------------------------------------------------------
    | TRANSFER
    |--------------------------------------------------------------------------
    */
    Route::get('/things/{thing}/transfer', [ThingController::class, 'transferForm'])
        ->name('things.transfer.form');

    Route::post('/things/{thing}/transfer', [ThingController::class, 'transfer'])
        ->name('things.transfer');
});
