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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('sensors', 'Api\EquipmentsApiController@updateSensorValue');

Route::get('sensors/{name}', 'Api\EquipmentsApiController@getSensorValue');

Route::post('/things/changeFanStatus/{id}/{value}', 'Api\ThingsApiController@changeFanStatus');
Route::post('/things/changeDoorStatus/{id}/{value}', 'Api\ThingsApiController@changeDoorStatus');
