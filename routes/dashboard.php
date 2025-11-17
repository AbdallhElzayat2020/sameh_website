<?php

use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\PermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->as('dashboard.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Roles Routes
    Route::resource('roles', RoleController::class);

    // Permissions Routes
    Route::resource('permissions', PermissionController::class);
});
