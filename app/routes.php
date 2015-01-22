<?php

use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'PartyController@index');
Route::resource('party', 'PartyController');
Route::resource('party.links', 'PartyLinkController');
Route::resource('party.emails', 'PartyEmailController');
Route::resource('party.phones', 'PartyPhoneController');
Route::resource('party.addresses', 'PartyAddressController');


// Authentication / Account management
Route::get('login', 'AuthController@login');
Route::post('login', 'AuthController@authenticate');
Route::get('logout', 'AuthController@logout');
Route::get('register', 'AuthController@create');
Route::post('register', 'AuthController@store');
Route::get('my_account', 'AuthController@edit');
Route::post('my_account', 'AuthController@update');



// Edit user for party
Route::get('party/{id}/user', 'UserController@show');
Route::post('party/{id}/user/store', 'UserController@store');
Route::put('party/{id}/user/update', 'UserController@update');

/**
 * Assets
 */

Route::get('includes/css/{script}', 'AssetController@getStylesheet')
	->where('script', '[A-Za-z0-9\/\-_\.]+.css$');

Route::get('includes/js/{script}', 'AssetController@getJavascript')
	->where('script', '[A-Za-z0-9\/\-_\.]+.js$');

Route::get('includes/fonts/{script}', 'AssetController@getFont')
	->where('script', '[A-Za-z0-9\/\-_\.]+');


/**
 * Errors
 */

// Missing routes return a 404
App::missing(function($exception)
{
	return App::make('ErrorController')->get404();
});

// MethodNotAllowed gets tossed separately
App::error(function(MethodNotAllowedHttpException $exception)
{
    return App::make('ErrorController')->get405();
});
