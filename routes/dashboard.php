<?php

use App\Http\Controllers\Dashboard\{
    ClientController,
    HomeController,
    PermissionController,
    ProjectRequestController,
    RoleController,
    UserController
};
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware('auth')->as('dashboard.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Users Routes
    Route::resource('/users', UserController::class);

    // Roles Routes
    Route::resource('/roles', RoleController::class);

    // Permissions Routes
    Route::resource('/permissions', PermissionController::class);

    // Clients Routes
    Route::resource('/clients', ClientController::class);

    // Project Requests Routes
    Route::get('/project-requests', [ProjectRequestController::class, 'index'])
        ->name('project-requests.index');

    Route::get('/project-requests/{projectRequest}', [ProjectRequestController::class, 'show'])
        ->name('project-requests.show');

    Route::get('/project-requests/{projectRequest}/attachments/{media}', [ProjectRequestController::class, 'downloadAttachment'])
        ->name('project-requests.attachments.download');

    Route::delete('/project-requests/{projectRequest}/attachments/{media}', [ProjectRequestController::class, 'destroyAttachment'])
        ->name('project-requests.attachments.destroy');

    Route::patch('/project-requests/{projectRequest}/status', [ProjectRequestController::class, 'updateStatus'])
        ->name('project-requests.update-status');

    Route::delete('/project-requests/{projectRequest}', [ProjectRequestController::class, 'destroy'])
        ->name('project-requests.destroy');
});
