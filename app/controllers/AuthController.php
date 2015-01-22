<?php

class AuthController extends \BaseController {

	public function login()
	{
		if(Sentry::check())
		{
			return Redirect::to('/');
		}

		$this->loadView('auth.login');
	}

	public function authenticate()
	{
		$error = FALSE;

		try
		{
		    // Login credentials
		    $credentials = array(
		        'login'    => Input::get('username'),
		        'password' => Input::get('password'),
		    );

		    // Authenticate the user
		    $user = Sentry::authenticate($credentials, (bool) Input::get('remember'));
			Sentry::login($user, (bool) Input::get('remember'));
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			$error = Lang::get('validation.required', array(
				'attribute' => Lang::get('auth.login_username'),
			));
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			$error = Lang::get('validation.required', array(
				'attribute' => Lang::get('auth.login_password'),
			));
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
			$error = Lang::get('auth.vague_failure');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			$error = Lang::get('auth.vague_failure');
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			$error = Lang::get('auth.message_not_activated');
		}

		// The following is only required if the throttling is enabled
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
			$error = Lang::get('auth.vague_failure');
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
			$error = Lang::get('auth.vague_failure');
		}

		if($error)
		{
			// Login failure...
			Notification::error($error);
			return Redirect::action('AuthController@login');
		}
		else
		{
			// Logged in successfully!
			Notification::success(Lang::get('auth.login_successful'));
			return Redirect::to('/');
		}
	}

	public function logout()
	{
		Sentry::logout();

		Notification::success(Lang::get('auth.logout_successful'));

		return Redirect::action('AuthController@login');
	}

	public function create()
	{

	}

	public function store()
	{
		
	}

	public function edit()
	{
		
	}

	public function update()
	{
		
	}

}
