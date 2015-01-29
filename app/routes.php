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

// Homepage
Route::get('/', 'HomeController@index');


// Administration
Route::group(array(
	'before' => array('admin'),
	'prefix' => 'dashboard',
), function() {
	// Dashboard
	Route::get('/', 'DashboardController@index');

	// Parties
	Route::resource('contacts.links', 'PartyLinkController');
	Route::resource('contacts.emails', 'PartyEmailController');
	Route::resource('contacts.phones', 'PartyPhoneController');
	Route::resource('contacts.addresses', 'PartyAddressController');
	Route::resource('contacts', 'PartyController');
	Route::resource('contacts.user', 'UserController');

	// Security
	Route::resource('security', 'UserGroupController');
	Route::get('security/{id}/new_permission', 'UserGroupController@newPermission');
	Route::post('security/{id}/new_permission', 'UserGroupController@storePermission');
	Route::post('security/{id}', 'UserGroupController@updatePermissions');
});

Route::when('dashboard/contacts/*', 'party');


// Authentication / Account management
Route::get('login', 'AuthController@login');
Route::post('login', 'AuthController@authenticate');
Route::get('logout', 'AuthController@logout');
Route::get('register', 'AuthController@create');
Route::post('register', 'AuthController@store');
Route::get('my_account', 'AuthController@edit');
Route::put('my_account', 'AuthController@update');
// Route::get('my_account/edit', 'AuthController@edit');


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

App::error(function($exception, $code)
{
    switch ($code)
    {
        case 403:
        	if(!Sentry::check())
        	{
        		Notification::warning('Please log in first.');
        		return Redirect::guest('login');
        	}
        	else
        	{
				return App::make('ErrorController')->get403();
        	}
			break;

        case 404:
			return App::make('ErrorController')->get404();
			break;
    }
});

// MethodNotAllowed gets tossed separately
App::error(function(MethodNotAllowedHttpException $exception)
{
    return App::make('ErrorController')->get405();
});
