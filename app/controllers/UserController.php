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

		$groups = Sentry::findAllGroups();
		$group_options = array();
		if(count($groups))
		{
			foreach($groups as $g)
			{
				$group_options[$g->id] = $g->name;
			}
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'party' => $party,
			'user' => new User,
			'crumbs' => Breadcrumbs::render('action', Lang::choice('labels.account', 1), 'party', $party),
		);

		View::share($aViewData);

		$aViewData['group_options'] = $group_options;
		$aViewData['set_group_ids'] = array();

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

		$user = new User;
		$user->removeRule('password', 'confirmed');
		$user->password = Input::get('password');
		$success = ($user->validate());
		$errors = array();

		if($success)
		{
		    // Let's register a user.
		    $user->party()->associate($party);
		    $user->activated = 1; // auto-activate
		    $user->save();

			$user = User::find($partyId);
			$user->removeRule('password', 'confirmed');

			try
			{
				$set_groups = Input::get('groups');

				if(count($set_groups))
				{
					foreach($set_groups as $g)
					{
						if($group = Sentry::findGroupById($g))
						{
							$user->addGroup($group);
						}
					}
				}
			}
			catch(Exception $e)
			{
				$errors['groups[]'] = $e->getMessage();
			}

			$user->save();
		}

		$errors = array_merge(
			$user->errors()->toArray(),
			$errors
		);

		if(!count($errors))
		{
			 // All good, new account created.
		    Notification::success(Lang::get('auth.account_created'));
		    return Redirect::action('UserController@show', array($party->id, $user->id));
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

		$groups = Sentry::findAllGroups();
		$group_options = array();
		if(count($groups))
		{
			foreach($groups as $g)
			{
				$group_options[$g->id] = $g->name;
			}
		}

		$group_ids = array();
		if($user->groups)
		{
			foreach($user->groups as $g)
			{
				$group_ids[] = $g->id;
			}
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'user' => $user,
			'party' => $party,
			'group_options' => $group_options,
			'set_group_ids' => $group_ids,
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
		$errors = array();
		$user = User::find($id);

		if(!$user)
		{
			return App::abort(404);
		}
		else
		{
			$party = $user->party;
		}

		try
		{
			$user->removeRule('password', 'confirmed');
			if(Input::get('password'))
			{
				$user->password = Input::get('password');
			}
			$success = ($user->validate());

			$set_groups = Input::get('groups');

			$existing_groups = $user->groups;
			if(count($existing_groups))
			{
				foreach($existing_groups as $g)
				{
					$user->removeGroup($g);
				}
			}

			if(count($set_groups))
			{
				foreach($set_groups as $g)
				{
					if($group = Sentry::findGroupById($g))
					{
						$user->addGroup($group);
					}
				}
			}

			$user->avatar = Input::file('avatar');

			$user->save();
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			$errors['groups[]'] = Lang::get('usergroups.not_found');
		}


		if(!count($errors))
		{
			Notification::success(Lang::get('messages.updated', array(
				'name' => Lang::choice('labels.user', 1),
			)));
			
			return Redirect::action('UserController@show', array($party->id, $user->id));
		}

		Notification::error($errors[key($errors)]);
		return Redirect::action('UserController@edit', array($party->id, $user->id))
			->withErrors($errors)
			->withInput();
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
