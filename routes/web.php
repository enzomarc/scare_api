<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json('API is alive.');
});

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {

    Route::get('clinics', 'ClinicController@all');

    Route::get('something', function () {
    	return response()->json('Something is still alive too.');
    });

});
