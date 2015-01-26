<?php

class UserController extends \BaseController {

	protected $layout = 'party';

	/**
	 * Re-routes to Create or Edit a party's account.
	 *
	 * @return Response
	 */
	public function index($partyId)
	{
		try
		{
			$user = Sentry::findUserById($partyId);
		}
		catch(Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return $this->create($partyId);
		}

		return $this->show($partyId, $user->id);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($partyId)
	{
		$party = Party::find($partyId);

		if(!$party)
		{
			return App::abort(404);
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'party' => $party,
			'user' => new User,
			'crumbs' => Breadcrumbs::render('action', Lang::choice('labels.account', 1), 'party', $party),
		);

		View::share($aViewData);

		// Render the view
		$this->loadView('users.create', $aViewData);

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($partyId)
	{
		$party = Party::find($partyId);

		if(!$party)
		{
			return App::abort(404);
		}

		// $party = new Party;
		// $party->type = 'p';
		// $success = $party->validate();

		// $person = new Person;

		// $email = new PartyEmail;
		// $success = ($email->validate() && $success);

		$user = new User;
		$user->removeRule('password', 'confirmed');
		$user->password = Input::get('password');
		$success = ($user->validate());

		$errors = array_merge(
			$user->errors()->toArray()
		);

		if($success)
		{
		    // Let's register a user.
		    $user->party()->associate($party);
		    $user->activated = 1; // auto-activate
		    $user->save();
		}

		if(!count($errors))
		{
			 // All good, new account created.
		    Notification::success(Lang::get('auth.account_created'));
		    return Redirect::to('/');
		}
		else
		{
			// So, it failed.
		}

		Notification::error($errors[key($errors)]);
		return Redirect::action('UserController@create', array($party->id))
			->withErrors($errors)
			->withInput();
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($partyId, $id)
	{
		$user = User::find($id);

		if(!$user)
		{
			$user = new User;
			$party = Party::find($id);

			if(!$party)
			{
				return App::abort(404);
			}
		}
		else
		{
			$party = $user->party;
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'user' => $user,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('action', Lang::choice('labels.account', 1), 'party', $party),
		);

		View::share($aViewData);

		// Render the view
		$this->loadView('users.show', $aViewData);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($partyId, $id)
	{
		$user = User::find($id);

		if(!$user)
		{
			return App::abort(404);
		}
		else
		{
			$party = $user->party;
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'user' => $user,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('action', Lang::choice('labels.account', 1), 'party', $party),
		);

		View::share($aViewData);

		// Render the view
		$this->loadView('users.edit', $aViewData);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($partyId, $id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($partyId, $id)
	{
		//
	}


}
