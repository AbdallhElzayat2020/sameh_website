<?php

use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware('auth')->as('dashboard.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Users Routes
    Route::resource('/users', UserController::class);

    // Roles Routes
    Route::resource('/roles', RoleController::class);

    // Permissions Routes
    Route::resource('/permissions', PermissionController::class);
});
