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

	// Clinic routes
    Route::get('clinic', 'ClinicController@index');
    Route::get('clinic/{clinic}', 'ClinicController@show');
    Route::post('clinic', 'ClinicController@store');
    Route::put('clinic/{clinic}', 'ClinicController@update');
    Route::delete('clinic/{clinic}', 'ClinicController@destroy');
    Route::get('clinic/{clinic}/toggle', 'ClinicController@toggle');

    // User routes
	Route::get('users', 'UserController@index');
	Route::get('users/{user}', 'UserController@show');
	Route::post('users', 'UserController@store');
	Route::put('users/{user}', 'UserController@update');
	Route::delete('users/{user}', 'UserController@destroy');
	Route::get('users/{user}/toggle', 'UserController@toggle');
	
});
