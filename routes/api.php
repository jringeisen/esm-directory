<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** Unauthenticated api routes */
Route::middleware(['api'])->group(function () {
    /** GET Routes */
    Route::get('/directory', 'DirectoryController@index');
});

/** Authenticated api routes */
Route::middleware(['auth:api'])->group(function () {
    /** GET Routes */
    Route::get('/user', 'UserController');

    /** API Resource Routes */
    Route::apiResource('/listings', 'ListingController');
    Route::apiResource('/packages', 'PackageController');

    /** Admin Routes */
    Route::apiResource('/roles', 'RoleController');
});
