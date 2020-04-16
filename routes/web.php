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
Route::get('/', function () {
    return view('guest.landing');
});

Route::get('/directory', 'DirectoryController@index');

//Auth Routes
Auth::routes();

//Authenticated User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/passport/clients', function () {
        return view('authenticated.passport.clients_index');
    });

    Route::get('/passport/authorized_clients', function () {
        return view('authenticated.passport.authorized_index');
    });

    Route::get('/passport/access_tokens', function () {
        return view('authenticated.passport.access_tokens_index');
    });

    Route::get('/listings', 'ListingController@index');
    Route::get('/packages', 'PackageController@index');
});
