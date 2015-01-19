<?php

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
