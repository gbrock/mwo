<?php

class PartyController extends \BaseController {

	/**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->beforeFilter('@filterRequests');

    	parent::__construct();
    }

    /**
     * Filter the incoming requests.
     */
    public function filterRequests($route, $request)
    {
    	$target = explode('@', $route->getActionName());

    	if(count($target) === 2)
    	{
    		$method = $target[1];
	    	switch($method)
	    	{
	    		// Change the layout for these requests
	    		case 'show':
	    		case 'edit':
	    			$this->layout = 'party';
	    			break;
	    	}
    	}

    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Get the amount of records per page
		$iLimit = $this->getLimit();

		// Get the records we need to display
		$parties = Party::paginate($iLimit);

		// Set up the data needed by the view(s)
		$aViewData = array(
			'page_title' => Lang::choice('labels.party', 0),
			'crumbs' => Breadcrumbs::render('parties'),
		);

		View::share($aViewData);

		$aViewData['records'] = $parties;
		$aViewData['sort_url'] = 'directory?';

		// Render the view
		$this->loadView('parties.index', $aViewData);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		 // By default create an individual, but listen to the Input
		$sPartyType = Input::old('type', 'p');

		// Set up the data needed by the view(s)
		$aViewData = array(
			'page_title' => Lang::get('parties.create'),
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.create'), 'parties'),
			'party_type' => $sPartyType,
		);

		View::share($aViewData);

		switch($sPartyType)
		{
			case 'p':
				$aViewData['party_type_form'] = 'people.form';
				break;
			case 'o':
				$aViewData['party_type_form'] = 'organizations.form';
				break;
			default:
				return App::abort();
				break;
		}

		// Render the view
		$this->loadView('parties/create', $aViewData);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Input::get('save') !== NULL) // save attempt
		{
			$party = new Party;

			$success = $party->validate();

			switch($party->type)
			{
				case 'p':
					$type = new Person;
					break;
				case 'o':
					$type = new Organization;
					break;
				default:
					return App::abort();
					break;
			}

			$success = $type->validate() && $success;

			if($success) // Validated
			{
				$party->save();
				$type->party()->associate($party);
				$type->save();

				Notification::success(Lang::get('messages.created', array('name' => $party->name)));
				return Redirect::action('PartyController@show', $party->id);
			}

			// Otherwise, it failed.
			Notification::error($party->errors()->all());
			return Redirect::action('PartyController@create')
				->withErrors(array_merge(
					$party->errors()->toArray(),
					$type->errors()->toArray()
				))
				->withInput();
		}
		elseif(Input::get('type')) // just switching types
		{
			return Redirect::action('PartyController@create')
				->withInput();
		}

		return App::abort(404);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$party = Party::find($id);

		if(!$party) {
			return App::abort(404);
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'party' => $party,
			'crumbs' => Breadcrumbs::render('party', $party),
		);

		$aViewData['page_title'] = $party->name;

		// Share it with the layout
		View::share($aViewData);

		// Render the view
		$this->loadView('parties.show', $aViewData);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$party = Party::find($id);

		if(!$party) {
			return App::abort(404);
		}

		View::share('party', $party);

		// Type is derived from model and cannot be changed
		$sPartyType = $party->type;

		// Set up the data needed by the view(s)
		$aViewData = array(
			'party' => $party, // Main object
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.edit'), 'party', $party), // Breadcrumbs
			'active_action' => 'PartyController@show', // Visibly-highlighted action
		);
		
		$aViewData['page_title'] = Lang::get('labels.edit_item', array('item' => $party->name));

		// Share it with the layout
		View::share($aViewData);

		switch($sPartyType)
		{
			case 'p':
				$aViewData['party_type_form'] = 'people.form';
				break;
			case 'o':
				$aViewData['party_type_form'] = 'organizations.form';
				break;
			default:
				return App::abort();
				break;
		}


		$aViewData['party_type'] = $sPartyType;

		// Render the view
		$this->loadView('parties.edit', $aViewData);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$party = Party::find($id);

		if(!$party) {
			return App::abort(404);
		}

		if(Input::get('save') !== NULL) // save attempt
		{
			$type = FALSE;

			if($party->person()->exists())
			{
				$type =& $party->person;
			}
			elseif($party->organization()->exists())
			{
				$type =& $party->organization;
			}

			$success = $party->save();
			$success = $type->save() && $success;

			if($success) // Validated and stored
			{
				Notification::success(Lang::get('messages.updated', array('name' => $party->name)));
				return Redirect::action('PartyController@show', $party->id);
			}

			// Otherwise, it failed.
			Notification::error($party->errors()->all());
			return Redirect::action('PartyController@edit', $party->id)
				->withErrors(array_merge(
					$party->errors()->toArray(),
					($type ? $type->errors()->toArray() : array())
				))
				->withInput();
		}

		return App::abort(404);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$party = Party::find($id);

		if(!$party) {
			return App::abort(404);
		}

		Notification::error(Lang::get('messages.deleted', array('name' => $party->name)));
		$party->delete();

		return Redirect::action('PartyController@index');
	}
}
