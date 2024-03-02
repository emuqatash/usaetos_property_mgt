<?php

use App\Http\Controllers\contactAttachmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\JobAttachmentFileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobPermitFileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SpecificationAttachmentController;
use App\Http\Controllers\SpecificationController;
use Illuminate\Foundation\Application;
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

Route::middleware('auth')->group(function () {
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

    Route::get('/jobs/new', \App\Http\Controllers\Jobs\NewJobsController::class)->name('jobs.new');

    Route::get('/estimates/drafts',
        \App\Http\Controllers\Estimates\DraftEstimatesController::class)->name('estimates.drafts');

    Route::get('/contracts/pending',
        \App\Http\Controllers\Contracts\PendingContractsController::class)->name('contracts.pending');

    Route::get('/invoices/drafts',
        \App\Http\Controllers\Invoices\DraftInvoicesController::class)->name('invoices.drafts');

    Route::get('/purchase-orders/drafts',
        \App\Http\Controllers\PurchaseOrders\DraftPurchaseOrdersController::class)->name('purchase-orders.drafts');

    Route::get('/supply/items', \App\Http\Controllers\Supply\SupplyItemController::class)->name('supply.items');

    Route::delete('/contact-attachment-files/{id}', [ContactAttachmentController::class, 'destroy'])->name('contact-attachment-files.destroy');
    Route::resource('contacts', ContactController::class);

    Route::delete('/job-permit-files/{id}', [JobPermitFileController::class, 'destroy'])->name('job-permit-files.destroy');
    Route::delete('/job-attachment-files/{id}', [JobAttachmentFileController::class, 'destroy'])->name('job-attachment-files.destroy');
    Route::resource('jobs', JobController::class);

    Route::delete('/specification-attachment-files/{id}', [specificationAttachmentController::class, 'destroy'])->name('specification-attachment-files.destroy');
    Route::resource('specifications', SpecificationController::class);

    Route::get('/property/{id}/duplicate',  [PropertyController::class, 'duplicate'])->name('property.duplicate');
    Route::resource('property', PropertyController::class);

    Route::resource('contract', ContractController::class);


    //    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
