<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Guest Routes
Route::get('/landing', function () {
    return view('guest.landing');
});

Route::get('/', 'DirectoryController@index');

//Auth Routes
Auth::routes();

//Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/user', 'UserController');

    Route::get('/passport/clients', function () {
        return view('authenticated.passport.index');
    });

    Route::apiResource('/listings', 'ListingController');
    Route::apiResource('/packages', 'PackageController');
});
