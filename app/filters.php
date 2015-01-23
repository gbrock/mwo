<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	App::setLocale('en');

	/**
	 * Outputs a FontAwesome glyphicon.
	 * @var [type]
	 */
	HTML::macro('icon', function($class, $nbs = 1)
	{
	    return '<span class="fa fa-' . $class . '" aria-hidden="true">' . str_repeat('&nbsp;', $nbs) . '</span>';
	});

	/**
	 * Prepends a URL with the provided scheme as needed.
	 * @var string
	 */
	HTML::macro('prep_url', function($url, $scheme = 'http://')
	{
	  return parse_url($url, PHP_URL_SCHEME) === null ?
	    $scheme . $url : $url;
	});

	/**
	 * Set up our site menus.
	 */
	Menu::make('mainMenu', function($menu){
		$parties = $menu->add('Contacts',  array('action' => 'PartyController@index'));

		switch(Request::segment(1))
		{
			case 'party':
				$parties->active();
				break;
		}
	});

	Menu::make('userMenu', function($menu){
		if(Sentry::check())
		{
			$display_name = Sentry::getUser()->party->name;
			$user_menu = $menu->add(HTML::icon('user text-primary') . $display_name,  array('action' => 'AuthController@edit'));
			$menu->add(Lang::get('titles.logout'),  array('action' => 'AuthController@logout'));

			switch(Request::segment(1))
			{
				case 'my_account':
					$user_menu->active();
					break;
			}
		}
		else
		{
			$menu->add(Lang::get('titles.register'),  array('action' => 'AuthController@create'));
			$menu->add(Lang::get('titles.login'),  array('action' => 'AuthController@login'));
		}
	});
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
