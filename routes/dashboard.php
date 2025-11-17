<?php

use App\Http\Controllers\Dashboard\{
    ClientController,
    ContactMessageController,
    FreelancerController,
    HomeController,
    IndustryController,
    IosImageController,
    PermissionController,
    ProjectRequestController,
    RoleController,
    ServiceController,
    TaskController,
    TestimonialController,
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

    Route::get('/clients/{client}/attachments/{media}', [ClientController::class, 'downloadAttachment'])
        ->name('clients.attachments.download');

    Route::delete('/clients/{client}/attachments/{media}', [ClientController::class, 'destroyAttachment'])
        ->name('clients.attachments.destroy');

    // Freelancers Routes
    Route::resource('/freelancers', FreelancerController::class);
    Route::get('/freelancers/{freelancer}/attachments/{media}', [FreelancerController::class, 'downloadAttachment'])
        ->name('freelancers.attachments.download');
    Route::delete('/freelancers/{freelancer}/attachments/{media}', [FreelancerController::class, 'destroyAttachment'])
        ->name('freelancers.attachments.destroy');

    // Services Routes
    Route::resource('/services', ServiceController::class);

    // Industries Routes
    Route::resource('/industries', IndustryController::class);

    // Tasks Routes
    Route::get('/tasks/find-client-or-freelancer', [TaskController::class, 'findClientOrFreelancer'])
        ->name('tasks.find-client-or-freelancer');
    Route::post('/tasks/{task}/upload-files', [TaskController::class, 'uploadFiles'])
        ->name('tasks.upload-files');
    Route::post('/tasks/{task}/attachments', [TaskController::class, 'storeAttachment'])
        ->name('tasks.attachments.store');
    Route::get('/tasks/{task}/attachments/{media}', [TaskController::class, 'downloadAttachment'])
        ->name('tasks.attachments.download');
    Route::delete('/tasks/{task}/attachments/{media}', [TaskController::class, 'destroyAttachment'])
        ->name('tasks.attachments.destroy');
    Route::resource('/tasks', TaskController::class);

    // Testimonials Routes
    Route::resource('/testimonials', TestimonialController::class)->except(['show']);

    // Contact Messages Routes
    Route::resource('/contact-messages', ContactMessageController::class)->only(['index', 'show', 'destroy']);

    // IOS Images Routes
    Route::resource('/ios-images', IosImageController::class)->except(['show']);

    // Project Requests Routes
    Route::get('/project-requests', [ProjectRequestController::class, 'index'])
        ->name('project-requests.index');

    Route::get('/project-requests/{projectRequest}', [ProjectRequestController::class, 'show'])
        ->name('project-requests.show');

    Route::get('/project-requests/{projectRequest}/attachments/{media}', [ProjectRequestController::class, 'downloadAttachment'])
        ->name('project-requests.attachments.download');

    Route::delete('/project-requests/{projectRequest}/attachments/{media}', [ProjectRequestController::class, 'destroyAttachment'])
        ->name('project-requests.attachments.destroy');

    Route::post('/project-requests/{projectRequest}/attachments', [ProjectRequestController::class, 'storeAttachment'])
        ->name('project-requests.attachments.store');

    Route::patch('/project-requests/{projectRequest}/status', [ProjectRequestController::class, 'updateStatus'])
        ->name('project-requests.update-status');

    Route::delete('/project-requests/{projectRequest}', [ProjectRequestController::class, 'destroy'])
        ->name('project-requests.destroy');
});
