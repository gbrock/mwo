<?php

class PartyController extends \BaseController {


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
		$aViewData = array();
		$aViewData['records'] = $parties;
		$aViewData['sort_url'] = 'directory?';

		// Set up the breadcrumbs
		$aViewData['crumbs'] = Breadcrumbs::render('parties');

		// Render the view
		$this->layout->content = View::make('parties/index', $aViewData);
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
		$aViewData = array();

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

		// Set up the breadcrumbs
		$aViewData['crumbs'] = Breadcrumbs::render('action', Lang::get('labels.create'), 'parties');

		// Render the view
		$this->layout->content = View::make('parties/create', $aViewData);
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
		);

		// Set up the breadcrumbs
		$aViewData['crumbs'] = Breadcrumbs::render('party', $party);

		// Render the view
		$this->layout->content = View::make('parties/show', $aViewData);
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

		// $this->layout->content = View::make('layouts.party');

		View::share('party', $party);

		// Type is derived from model and cannot be changed
		$sPartyType = $party->type;

		// Set up the data needed by the view(s)
		$aViewData = array(
			'party' => $party,
		);

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
		$aViewData['active_action'] = 'PartyController@show';

		// Set up the breadcrumbs
		$aViewData['crumbs'] = Breadcrumbs::render('action', Lang::get('labels.edit'), 'party', $party);

		// Render the view
		$this->layout->inner = View::make('parties/edit', $aViewData);
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
