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

Route::get('/', function (Request $request) {
    if ($request->ajax()) {
        return response()->json(Listing::all());
    }

    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    Route::get('/listings', 'ListingController@index')->name('listings.index');
    Route::post('/listings', 'ListingController@store')->name('listings.store');
    Route::put('/listings/{listing}', 'ListingController@update')->name('listings.update');
    Route::delete('/listings/{listing}', 'ListingController@destroy')->name('listings.destroy');

    Route::get('/packages/create', 'PackageController@create')->name('packages.create');
    Route::post('/packages', 'PackageController@store')->name('packages.store');
});
