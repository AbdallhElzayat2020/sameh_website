<?php

use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\ClientInvoiceController;
use App\Http\Controllers\Dashboard\ClientPoController;
use App\Http\Controllers\Dashboard\CompanyCapitalController;
use App\Http\Controllers\Dashboard\ContactMessageController;
use App\Http\Controllers\Dashboard\ExpenseController;
use App\Http\Controllers\Dashboard\FinanceController;
use App\Http\Controllers\Dashboard\FreelancerController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\IndustryController;
use App\Http\Controllers\Dashboard\IosImageController;
use App\Http\Controllers\Dashboard\PermissionController;
use App\Http\Controllers\Dashboard\ProjectRequestController;
use App\Http\Controllers\Dashboard\RevenueController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\ServiceController;
use App\Http\Controllers\Dashboard\TaskController;
use App\Http\Controllers\Dashboard\TestimonialController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\VendorInvoiceController;
use App\Http\Controllers\Dashboard\VendorPoController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware('auth')->as('dashboard.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::prefix('finance')->as('finance.')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('index');
        Route::get('/invoices', [FinanceController::class, 'invoices'])->name('invoices');

        Route::prefix('invoices')->name('invoices.')->group(function () {
            Route::get('vendor-invoices', [VendorInvoiceController::class, 'index'])->name('vendor-invoices');
            Route::patch('vendor-invoices/{vendorInvoice}', [VendorInvoiceController::class, 'update'])->name('vendor-invoices.update');
            Route::get('vendor-invoices/{vendorInvoice}/download-po', [VendorInvoiceController::class, 'downloadPo'])->name('vendor-invoices.download-po');

            Route::get('client-invoices', [ClientInvoiceController::class, 'index'])->name('client-invoices');
            Route::patch('client-invoices/{clientInvoice}', [ClientInvoiceController::class, 'update'])->name('client-invoices.update');
            Route::get('client-invoices/{clientInvoice}/download-po', [ClientInvoiceController::class, 'downloadPo'])->name('client-invoices.download-po');
        });

        Route::resource('revenues', RevenueController::class)->except(['show']);
        Route::post('revenues/{revenue}/sheet', [RevenueController::class, 'uploadSheet'])
            ->name('revenues.sheet.store');
        Route::get('revenues/{revenue}/sheet', [RevenueController::class, 'downloadSheet'])
            ->name('revenues.sheet.download');

        Route::resource('expenses', ExpenseController::class)->except(['show']);
        Route::post('expenses/{expense}/sheet', [ExpenseController::class, 'uploadSheet'])
            ->name('expenses.sheet.store');
        Route::get('expenses/{expense}/sheet', [ExpenseController::class, 'downloadSheet'])
            ->name('expenses.sheet.download');

        Route::get('company-capital', [CompanyCapitalController::class, 'index'])->name('company-capital.index');
        Route::get('company-capital/edit', [CompanyCapitalController::class, 'edit'])->name('company-capital.edit');
        Route::put('company-capital', [CompanyCapitalController::class, 'update'])->name('company-capital.update');
    });

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
    Route::get('/tasks/find-task', [TaskController::class, 'findTask'])
        ->name('tasks.find-task');
    Route::post('/tasks/{task}/upload-files', [TaskController::class, 'uploadFiles'])
        ->name('tasks.upload-files');
    Route::post('/tasks/{task}/attachments', [TaskController::class, 'storeAttachment'])
        ->name('tasks.attachments.store');
    Route::get('/tasks/{task}/attachments/{media}', [TaskController::class, 'downloadAttachment'])
        ->name('tasks.attachments.download');
    Route::delete('/tasks/{task}/attachments/{media}', [TaskController::class, 'destroyAttachment'])
        ->name('tasks.attachments.destroy');
    Route::resource('/tasks', TaskController::class);

    Route::prefix('/tasks/{task}')->name('tasks.')->scopeBindings()->group(function () {
        Route::get('vendor-pos', [VendorPoController::class, 'index'])->name('vendor-pos.index');
        Route::get('vendor-pos/create', [VendorPoController::class, 'create'])->name('vendor-pos.create');
        Route::post('vendor-pos', [VendorPoController::class, 'store'])->name('vendor-pos.store');
        Route::get('vendor-pos/{vendorPo}/download', [VendorPoController::class, 'download'])->name('vendor-pos.download');

        Route::get('client-pos', [ClientPoController::class, 'index'])->name('client-pos.index');
        Route::get('client-pos/create', [ClientPoController::class, 'create'])->name('client-pos.create');
        Route::post('client-pos', [ClientPoController::class, 'store'])->name('client-pos.store');
        Route::get('client-pos/{clientPo}/download', [ClientPoController::class, 'download'])->name('client-pos.download');
    });

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
