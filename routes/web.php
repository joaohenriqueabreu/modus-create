<?php

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
    return view('welcome');
});

/// Requirements routes
Route::prefix('vehicles')->group(function(){    

    /// [GET] Get Vehicle data from url params
    Route::get('{year}/{make}/{model}', 'VehicleController@getVehicle');    

    /// [POST] Get vehicle data from json post body
    Route::post('/', 'VehicleController@postVehicle');
});
