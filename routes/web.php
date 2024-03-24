<?php

use App\Http\Controllers\contactAttachmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JobAttachmentFileController;
use App\Http\Controllers\JobWorkController;
use App\Http\Controllers\JobPermitFileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyExpenseAttachmentController;
use App\Http\Controllers\PropertyExpenseController;
use App\Http\Controllers\PropertyRentController;
use App\Http\Controllers\SpecificationAttachmentController;
use App\Http\Controllers\SpecificationController;
use App\Http\Controllers\TenantAttachmentController;
use App\Http\Controllers\TenantContractAttachmentController;
use App\Http\Controllers\TenantContractController;
use App\Http\Controllers\TenantContractPaymentDetailController;
use App\Http\Controllers\TenantController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth',)->group(function () {
    Route::get('/settings/profile', \App\Http\Controllers\Settings\ProfileController::class)->name('settings.profile');
    Route::post('/settings/profile',
        \App\Http\Controllers\Settings\UpdateProfileController::class)->name('settings.profile.update');

    Route::get('/settings/business',
        \App\Http\Controllers\Settings\BusinessController::class)->name('settings.business');
    Route::post('/settings/business',
        \App\Http\Controllers\Settings\UpdateBusinessController::class)->name('settings.business.update');

    Route::get('/settings/team', \App\Http\Controllers\Settings\TeamController::class)->name('settings.team');
    Route::post('/settings/team/invite',
        \App\Http\Controllers\Settings\Team\InviteUserController::class)->name('settings.team.invite');
    Route::get('/settings/team/{user}',
        \App\Http\Controllers\Settings\Team\ViewUserProfileController::class)->name('settings.team.user');

//    Route::get('/jobs/new', \App\Http\Controllers\Jobs\NewJobsController::class)->name('jobs.new');
//
//    Route::get('/estimates/drafts',
//        \App\Http\Controllers\Estimates\DraftEstimatesController::class)->name('estimates.drafts');
//
//    Route::get('/invoices/drafts',
//        \App\Http\Controllers\Invoices\DraftInvoicesController::class)->name('invoices.drafts');
//
//    Route::get('/purchase-orders/drafts',
//        \App\Http\Controllers\PurchaseOrders\DraftPurchaseOrdersController::class)->name('purchase-orders.drafts');

    Route::delete('/contact-attachment-files/{id}', [ContactAttachmentController::class, 'destroy'])->name('contact-attachment-files.destroy');
    Route::resource('contacts', ContactController::class);

    Route::delete('/jobwork-permit-files/{id}', [JobPermitFileController::class, 'destroy'])->name('jobwork-permit-files.destroy');
    Route::delete('/jobwork-attachment-files/{id}', [JobAttachmentFileController::class, 'destroy'])->name('jobwork-attachment-files.destroy');
    Route::resource('jobworks', JobWorkController::class);

    Route::delete('/specification-attachment-files/{id}', [specificationAttachmentController::class, 'destroy'])->name('specification-attachment-files.destroy');
    Route::resource('specifications', SpecificationController::class);

    Route::get('/property/{id}/duplicate',  [PropertyController::class, 'duplicate'])->name('property.duplicate');
    Route::resource('property', PropertyController::class)->only(['index','create', 'edit', 'store', 'destroy']);

    Route::delete('/tenant-attachment-files/{id}', [TenantAttachmentController::class, 'destroy'])->name('tenant-attachment-files.destroy');
    Route::get('/tenant/{id}/duplicate',  [TenantController::class, 'duplicate'])->name('tenant.duplicate');
    Route::resource('tenant', TenantController::class)->only(['index','create', 'edit', 'store', 'destroy']);

    Route::delete('/tenant-contract-attachment-files/{id}', [TenantContractAttachmentController::class, 'destroy'])->name('tenant-contract-attachment-files.destroy');
    Route::get('/tenant-contract/{id}/duplicate',  [TenantContractController::class, 'duplicate'])->name('tenant-contract.duplicate');
    Route::get('/tenant-contract/{id}/createTenantContract',  [TenantContractController::class, 'createTenantContract'])->name('tenant-contract.createTenantContract');
    Route::resource('tenant-contract', TenantContractController::class)->only(['show', 'edit', 'store', 'destroy']);

//    PropertyExpense
    Route::delete('/property-expense-attachment-files/{id}', [PropertyExpenseAttachmentController::class, 'destroy'])->name('property-expense-attachment-files.destroy');
    Route::get('/property-expense/{id}/duplicate',  [PropertyExpenseController::class, 'duplicate'])->name('property-expense.duplicate');
    Route::get('/property-expense/{id}/createPropertyExpense',  [PropertyExpenseController::class, 'createPropertyExpense'])->name('property-expense.createPropertyExpense');
    Route::resource('property-expense', PropertyExpenseController::class)->only(['show', 'edit', 'store', 'destroy']);

    Route::get('/property-rent/{id}/duplicate',  [PropertyRentController::class, 'duplicate'])->name('property-rent.duplicate');
    Route::get('/property-rent/{id}/createPropertyRent',  [PropertyRentController::class, 'createPropertyRent'])->name('property-rent.createPropertyRent');
    Route::resource('property-rent', PropertyRentController::class)->only(['show', 'edit', 'store', 'destroy']);

//    Route::get('/tenant-contract-payment-detail/{id}/duplicate',  [TenantContractPaymentDetailController::class, 'duplicate'])->name('tenant-contract-payment-detail.duplicate');
//    Route::get('/tenant-contract-payment-detail/{id}/createPropertyRent',  [TenantContractPaymentDetailController::class, 'createPaymentDetail'])->name('tenant-contract-payment-detail.createPaymentDetail');
    Route::resource('tenant-contract-payment-detail', TenantContractPaymentDetailController::class);


    //    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
