<?php

use App\Http\Controllers\Api\GooglePlacesController;
use App\Http\Controllers\Api\TenantsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//all routes / api must be authenticated
Route::group(['middleware' => ['api', 'checkPassword'], 'namespace' => 'Api'], function () {
    Route::post('get-all-tenants', [TenantsController::class, 'getAllTenants']);
    Route::post('get-tenant-byid', [TenantsController::class, 'getTenantById']);
    Route::post('change-tenant-status', [TenantsController::class, 'changeTenantStatus']);

    Route::get('/google-places/autocomplete', [GooglePlacesController::class, 'autocomplete']);
});




//Route::get('/contacts', 'ContactController@index');
//Route::get('/contacts/withoutcache', 'ContactController@allWithoutcache');
