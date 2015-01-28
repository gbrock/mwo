<?php

class UserGroupController extends \BaseController {

	protected $layout = 'admin';

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$groups = Sentry::findAllGroups();

		$aViewData = array(
			'page_title' => Lang::choice('labels.usergroup', 0),
			'crumbs' => Breadcrumbs::render('usergroups'),
		);

		View::share($aViewData);

		$aViewData['groups'] = $groups;
		$aViewData['permissions'] = Permissions::getAll();

		$this->loadView('usergroups.index', $aViewData);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$aViewData = array(
			'page_title' => Lang::get('usergroups.create'),
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.create'), 'usergroups'),
		);

		View::share($aViewData);

		$this->loadView('usergroups.create', $aViewData);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$errors = array();
		try
		{
		    // Create the group
		    $group = Sentry::createGroup(array(
		        'name'        => trim(preg_replace('/\s+/', ' ', Input::get('name'))),
		    ));
		}
		catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
		{
		    $errors['name'] = 'Name field is required';
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
		    $errors['name'] = 'Group already exists';
		}

		if(!count($errors)) // valid, and done
		{
			Notification::success(Lang::get('messages.created', array(
				'name' => Lang::choice('labels.usergroup', 1),
			)));
			return Redirect::action('UserGroupController@index');
		}

		return Redirect::action('UserGroupController@create')
			->withErrors($errors)
			->withInput();
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		try
		{
		    $group = Sentry::findGroupById($id);
		}
		catch (Exception $e)
		{
			return App::abort(404);
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'page_title' => $group->name,
			'crumbs' => Breadcrumbs::render('usergroup', $group),
		);

		// Share it with the layout
		View::share($aViewData);

		$aViewData['permissions'] = Permissions::getAll();
		$aViewData['group'] = $group;

		// Render the view
		$this->loadView('usergroups.show', $aViewData);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		try
		{
		    $group = Sentry::findGroupById($id);
		}
		catch (Exception $e)
		{
			return App::abort(404);
		}

		$aViewData = array(
			'page_title' => Lang::get('usergroups.edit'),
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.edit'), 'usergroup', array($group)),
		);

		View::share($aViewData);

		$aViewData['group'] = $group;

		$this->loadView('usergroups.edit', $aViewData);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$errors = array();

		try
		{
		    // Find the group using the group id
		    $group = Sentry::findGroupById($id);

		    // Update the group details
		    $group->name = trim(preg_replace('/\s+/', ' ', Input::get('name')));

		    $group->save();
		}
		catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
		{
		    $errors['name'] = 'Name field is required';
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
		    $errors['name'] = 'Group already exists.';
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
			return App::abort(404);
		}

		if(!count($errors)) // valid, and done
		{
			Notification::success(Lang::get('messages.updated', array(
				'name' => Lang::choice('labels.usergroup', 1),
			)));
			return Redirect::action('UserGroupController@show', array($group->id));
		}

		return Redirect::action('UserGroupController@edit', array($id))
			->withErrors($errors)
			->withInput();
	}

	public function newPermission($id)
	{
		try
		{
		    $group = Sentry::findGroupById($id);
		}
		catch (Exception $e)
		{
			return App::abort(404);
		}

		$aViewData = array(
			'page_title' => Lang::get('usergroups.edit'),
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.create_item', array('item' => Lang::choice('labels.permission', 1))), 'usergroup', array($group)),
		);

		View::share($aViewData);

		$aViewData['group'] = $group;

		$this->loadView('usergroups.newPermission', $aViewData);
	}

	public function storePermission($id)
	{
		$errors = array();

		try
		{
		    $group = Sentry::findGroupById($id);
		}
		catch (Exception $e)
		{
			return App::abort(404);
		}

		$validator = Validator::make(
		    array(
		    	'name' => Input::get('name'),
		    	// 'allow' => Input::get('allow'),
		    ),
		    array(
		    	'name' => 'required',
		    	// 'allow' => 'required|boolean',
		    )
		);

		if($validator->passes())
		{
			$new_perm_key = trim(preg_replace('/\s+/', ' ', Input::get('name')));
			// $new_perm_value = (Input::get('allow') == 1 ? 1 : 0);

			$perms = $group->permissions;
			$perms[$new_perm_key] = 1;

			try
			{
				$group->permissions = $perms;
				$group->save();
			}
			catch(Exception $e)
			{
				$errors['name'] = $e->getMessage();
			}


			if(!count($errors))
			{
				Notification::success(Lang::get('messages.created', array(
					'name' => $new_perm_key,
				)));
				return Redirect::action('UserGroupController@show', array($group->id));
			}
		}
		else
		{
			$errors = $validator->messages();
		}

		

		return Redirect::action('UserGroupController@newPermission', array($id))
			->withErrors($errors)
			->withInput();
	}

	public function updatePermissions($id)
	{
		$errors = array();

		try
		{
		    $group = Sentry::findGroupById($id);

		    $all_permissions = Permissions::getAll();
		    $posted_permissions = Input::get('allow');
		    $new_permissions = array();

		    foreach($all_permissions as $p)
		    {
		    	if(isset($posted_permissions[$p]))
		    	{
		    		$new_permissions[$p] = 1;
		    	}
		    	else
		    	{
		    		$new_permissions[$p] = 0;
		    	}
		    }

		    $group->permissions = $new_permissions;
		    $group->save();
		}
		catch (Exception $e)
		{
			return App::abort(404);
		}

		Notification::success(Lang::get('messages.updated', array('name' => Lang::choice('labels.permission', 0))));
		return Redirect::action('UserGroupController@show', array($id));
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try
		{
		    // Find the group using the group id
		    $group = Sentry::findGroupById($id);

		    // Delete the group
		    $group->delete();
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    return App::abort(404);
		}


		Notification::success(Lang::get('messages.deleted', array(
			'name' => Lang::choice('labels.usergroup', 1),
		)));
		return Redirect::action('UserGroupController@index');
	}


}
