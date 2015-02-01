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
	});

	Menu::make('userMenu', function($menu){
		if($user = Sentry::getUser())
		{
			$display_name = $user->party->name;
			$menu->add(HTML::icon('dashboard') . Lang::get('titles.dashboard'), array(
				'action' => 'DashboardController@index',
			));
			$menu->add(HTML::icon('user text-primary') . $display_name,  array('action' => 'AuthController@edit'))
				->active('my_account/*');
			$menu->add(Lang::get('titles.logout'),  array('action' => 'AuthController@logout'));
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

Route::filter('admin', function($route, $request)
{
	/**
	 * Determine if the user is logged in.
	 */
	if(!Sentry::check())
	{
		return App::abort(403);
	}

	/**
	 * Set up our admin menus.
	 */
	Menu::make('adminMenu', function($menu){
		$menu->add(Lang::get('titles.pages'),  array('action' => 'PageController@index'))
			->active('dashboard/pages/*');
		$menu->add(Lang::get('titles.parties'),  array('action' => 'PartyController@index'))
			->active('dashboard/contacts/*');
		$menu->add(Lang::get('titles.security'),  array('action' => 'UserGroupController@index'))
			->active('dashboard/security/*');
	});
});

Route::filter('security', function($route, $request)
{
	/**
	 * Set up our security menu.
	 */
	Menu::make('securityMenu', function($menu)
	{
	    // The main security page
		$menu->add(
			HTML::icon($party->icon . ' fa-fw') . Lang::get('labels.overview'),
			array(
				'action' => array('PartyController@show', $party->id),
			)
		)->active('party/([0-9]*)/edit'); // active on this route
	});
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
