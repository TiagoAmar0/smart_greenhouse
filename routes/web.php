<?php

use Illuminate\Support\Facades\Route;

/** HOME PAGE */
Route::get('/', function () { return view('index'); });

/** DASHBOARD PAGE */
Route::get('/dashboard', 'DashboardController@index')->name('dashbboard');

/** SENSORS */
Route::resource('dashboard/sensors', 'SensorsController')->except('show');

Route::resource('dashboard/sensors/actions', 'SensorsActionsController')->except('show');
Route::get('/dashboard/sensors/actions/{id}', function () {
    return abort(404);
});
Route::get('/dashboard/sensors/{id}', function () {
    return abort(404);
});

/** AUTH */
Auth::routes();
