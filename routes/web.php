<?php

use Illuminate\Support\Facades\Route;

/** HOME PAGE */
Route::get('/', function () { return view('index'); });

/** ROUTES THAT NEED AUTHENTICATION */
Route::group(['middleware' => 'auth'], function(){
    /** DASHBOARD PAGE */
    Route::get('/dashboard', 'DashboardController@index')->name('dashbboard');

    /** ROUTES THAT REQUIRES ADMIN PRIVILEGES */
    Route::group(['middleware' => 'admin'], function(){
        /** SENSORS */
        Route::resource('dashboard/sensors', 'SensorsController')->except(['show', 'create', 'store', 'destroy']);

        // Show 404 error when trying to access create page or any display page
        Route::get('/dashboard/sensors/create', function () { return abort(404); });
        Route::get('/dashboard/sensors/{id}', function () { return abort(404); });
        Route::delete('/dashboard/sensors/{id}', function () { return abort(404); });

        /** EQUIPMENTS */
        Route::resource('/dashboard/equipments', 'EquipmentsController')->except(['show']);

        Route::resource('/dashboard/equipments/actions', 'ActionsController')->except('show');
        Route::get('/dashboard/equipments/actions/{id}', function () { return abort(404); });

        /** STATES */
        Route::resource('/dashboard/equipments/states', 'StatesTextController')->except('show');
        Route::get('/dashboard/equipments/states/{id}', function () { return abort(404); });
        Route::get('/dashboard/equipments/{id}', function () { return abort(404); });


        /** EQUIPMENTS ACTIONS */
        Route::post('/things/changeDoorStatus/{id}/{value}', 'ThingsController@changeDoorStatus');
        Route::post('/things/changeFanStatus/{id}/{value}', 'ThingsController@changeFanStatus');
        Route::post('/atuators/changeLampStatus/{id}/{value}', 'AtuatorsController@changeLampStatus');



        /** USERS */
        Route::resource('dashboard/users', 'UsersController')->except(['show','destroy']);
        Route::get('/dashboard/users/{id}', function () { return abort(404); });
        Route::delete('/dashboard/users/{id}', function () { return abort(404); });
        Route::put('/dashboard/users/togglePermissions/{id}', 'UsersController@togglePermissions');
    });

    /** HISTORY */
    Route::get('/dashboard/equipments/history/webcam', 'EquipmentsController@webcamHistory');
    Route::get('/dashboard/equipments/history/{id}', 'EquipmentsController@history');

    /** PROFILE */
    Route::get('/dashboard/profile', 'UsersController@profile');
    Route::post('profile','UsersController@update_avatar');
});


/** AUTH */
Auth::routes();
