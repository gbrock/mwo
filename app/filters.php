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
		$menu->add(Lang::get('titles.parties'),  array('action' => 'PartyController@index'))
			->active('party/*');
	});

	Menu::make('userMenu', function($menu){
		if(Sentry::check())
		{
			$display_name = Sentry::getUser()->party->name;
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

Route::filter('party', function($route, $request)
{
	/**
	 * Set up our site menus.
	 */
	Menu::make('partyMenu', function($menu){
	    if($party = Party::all()->find(Request::segment(2)))
	    {
		    // The main party page
			$menu->add(
				HTML::icon($party->icon . ' fa-fw') . Lang::get('labels.overview'),
				array(
					'action' => array('PartyController@show', $party->id),
				)
			)->active('party/([0-9]*)/edit'); // active on this route

		    // The user page
			$menu->add(
				HTML::icon('key fa-fw') . Lang::choice('labels.account', 1),
				array(
					'action' => array('UserController@show', $party->id),
				)
			)->active('party/([0-9]*)/user/*'); // active on this route

			// The locators
			
			// Links
			$menu->add(
				(
					$party->links()->count() ? 
					'<span class="badge pull-right">' . number_format($party->links()->count()) . '</span>' : 
					''
				) . HTML::icon('link fa-fw') . Lang::choice('labels.party_link', 0),
				array(
					'action' => array('PartyLinkController@index', $party->id),
				)
			)->active('party/([0-9]*)/links/*'); // active on these routes
			
			// E-mails
			$menu->add(
				(
					$party->emails()->count() ? 
					'<span class="badge pull-right">' . number_format($party->emails()->count()) . '</span>' : 
					''
				) . HTML::icon('envelope-o fa-fw') . Lang::choice('labels.party_email', 0),
				array(
					'action' => array('PartyEmailController@index', $party->id),
				)
			)->active('party/([0-9]*)/emails/*'); // active on these routes
			
			// Phones
			$menu->add(
				(
					$party->phones()->count() ? 
					'<span class="badge pull-right">' . number_format($party->phones()->count()) . '</span>' : 
					''
				) . HTML::icon('phone fa-fw') . Lang::choice('labels.party_phone', 0),
				array(
					'action' => array('PartyPhoneController@index', $party->id),
				)
			)->active('party/([0-9]*)/phones/*'); // active on these routes
			
			// Addresses
			$menu->add(
				(
					$party->addresses()->count() ? 
					'<span class="badge pull-right">' . number_format($party->addresses()->count()) . '</span>' : 
					''
				) . HTML::icon('map-marker fa-fw') . Lang::choice('labels.party_address', 0),
				array(
					'action' => array('PartyAddressController@index', $party->id),
				)
			)->active('party/([0-9]*)/addresses/*'); // active on these routes
	    }
		
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
