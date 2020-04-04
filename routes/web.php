<?php

use App\Models\Listing;
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

Route::get('/', function () {
    $listings = Listing::all();
    return view('welcome', compact('listings'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/listings', 'ListingController@index')->name('listings.index');
Route::post('/listings', 'ListingController@store')->name('listings.store');
