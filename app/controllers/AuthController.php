<?php

class AuthController extends \BaseController {

	function __construct()
	{
		parent::__construct();

		// Menu::make('accountMenu', function($menu){
		// 	$menu->add('')
		// });
	}

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
		$aViewData = array(

		);

		$user = new User;

		$this->loadView('auth.create', $aViewData);
	}

	public function store()
	{
		$party = new Party;
		$party->type = 'p';
		$success = $party->validate();

		$person = new Person;

		$email = new PartyEmail;
		$success = ($email->validate() && $success);

		$user = new User;
		$user->password = Input::get('password');
		$success = ($user->validate() && $success);

		$errors = array_merge(
			$party->errors()->toArray(),
			$email->errors()->toArray(),
			$user->errors()->toArray()
		);

		if($success)
		{
			$party->save();

			$person->party()->associate($party);
			$person->save();

			$email->party()->associate($party);
			$email->save();

		    // Let's register a user.
		    $user->party()->associate($party);
		    $user->activated = 1; // auto-activate
		    $user->save();
		}

		if(!count($errors))
		{
			 // All good, new account created.
		    $user = Sentry::findUserByID($user->id);

			Sentry::login($user, FALSE);
		    Notification::success(Lang::get('auth.account_created'));
		    return Redirect::to('/');
		}
		else
		{
			// So, it failed.
			$party->delete();
		}

		Notification::error($errors[key($errors)]);
		return Redirect::action('AuthController@create')
			->withErrors($errors)
			->withInput();
	}

	public function show()
	{
		$aViewData = array(
			'user' => Sentry::getUser(),
		);

		$this->loadView('auth.show', $aViewData);
	}

	public function edit()
	{
		$aViewData = array(

		);

		Sentry::check();
		$user = Sentry::getUser();

		$aViewData['party'] =& $user->party;
		$aViewData['email'] = new PartyEmail;
		$aViewData['phone'] = new PartyPhone;
		$aViewData['address'] = new PartyAddress;
		$aViewData['link'] = new PartyLink;

		$this->loadView('auth.edit', $aViewData);
	}

	public function update()
	{
		Sentry::check();
		$user = Sentry::getUser();
		$user->password = Input::get('password');

		$success = $user->party->validate();
		$success = $user->validate() && $success;

		$errors = array_merge(
			$user->party->errors()->toArray(),
			$user->errors()->toArray()
		);

		if($success)
		{
			$user->party->save();
			$user->save();
		    Notification::success(Lang::get('auth.account_updated'));
		    return Redirect::action('AuthController@edit');
		}

		Notification::error($errors[key($errors)]);
		return Redirect::action('AuthController@edit')
			->withErrors($errors)
			->withInput();
	}

}
