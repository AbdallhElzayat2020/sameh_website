<?php

use App\Http\Controllers\Dashboard\HomeController;
use Illuminate\Support\Facades\Route;


Route::prefix('dashboard')->as('dashboard.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

});
