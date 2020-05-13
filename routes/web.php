<?php

use Illuminate\Support\Facades\Route;

/** HOME PAGE */
Route::get('/', function () { return view('index'); });

/** DASHBOARD PAGE */
Route::get('/dashboard', 'DashboardController@index')->name('dashbboard');

/** SENSORS */
Route::resource('dashboard/sensors', 'SensorsController')->except(['show', 'create', 'store']);

// Show 404 error when trying to access create page or any display page
Route::get('/dashboard/sensors/create', function () {
    return abort(404);
});
Route::get('/dashboard/sensors/{id}', function () {
    return abort(404);
});

/** EQUIPMENTS */
Route::resource('dashboard/equipments', 'EquipmentsController')->except('show');

Route::resource('dashboard/equipments/actions', 'ActionsController')->except('show');
Route::get('/dashboard/equipments/actions/{id}', function () {
    return abort(404);
});

Route::get('/dashboard/equipments/{id}', function () {
    return abort(404);
});

/** AUTH */
Auth::routes();
