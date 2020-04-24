<?php

use App\Models\User;
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
Auth::routes(['verify' => true]);

//Authenticated User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/passport/clients', function () {
        return view('admin.passport.clients_index');
    });

    Route::get('/passport/authorized_clients', function () {
        return view('admin.passport.authorized_index');
    });

    Route::get('/passport/access_tokens', function () {
        return view('admin.passport.access_tokens_index');
    });

    Route::get('/admin/users', function () {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    });

    Route::get('/profile', function () {
        return view('users.profile.index');
    });

    Route::get('/listings', 'ListingController@index');
    Route::get('/packages', 'PackageController@index');
    Route::get('/bookings', 'BookingController@index');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/admin/roles', 'RoleController@index');
    });
});
