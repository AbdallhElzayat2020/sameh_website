<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\PriceRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/price-request', [PriceRequestController::class, 'index'])->name('price-request');




// require __DIR__.'/dashboard.php';

Route::middleware('auth')->as('dashboard.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
