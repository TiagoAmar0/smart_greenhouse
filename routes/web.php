<?php

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

Route::get('/', function () { return view('index'); });

Route::get('/dashboard', 'DashboardController@index')->name('dashbboard');

/** SENSORS */
Route::resource('dashboard/sensors', 'SensorsController')->except('show');
Route::get('/dashboard/sensors/{id}', function () {
    return abort(404);
});

/** AUTH */
Auth::routes();
