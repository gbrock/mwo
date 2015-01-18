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
			$object = new Party;
			if($object->save()) // Validated and stored
			{
				// Notification::success('Party "' . $object->name . '" saved.');
				return Redirect::action('PartyController@show', $object->id);
			}

			// Otherwise, it failed.
			// Notification::error($object->errors()->all());
			return Redirect::action('PartyController@create')
				->withErrors($object->errors()->toArray())
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

		// Set up the breadcrumbs
		$aViewData['crumbs'] = Breadcrumbs::render('action', Lang::get('labels.edit'), 'party', $party);

		// Render the view
		$this->layout->content = View::make('parties/edit', $aViewData);
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
			$object =& $party;
			$type = FALSE;

			if($object->person()->exists())
			{
				$type =& $object->person;
			}
			elseif($object->organization()->exists())
			{
				$type =& $object->organization;
			}

			$success = $object->save();
			$success = $success && $type && $type->save();

			if($success) // Validated and stored
			{
				// Notification::success('Party "' . $object->name . '" saved.');
				return Redirect::action('PartyController@show', $party->id);
			}

			// Otherwise, it failed.
			// Notification::error($object->errors()->all());
			return Redirect::action('PartyController@edit', $party->id)
				->withErrors($object->errors()->toArray())
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

		$party->delete();

		return Redirect::action('PartyController@index');
	}
}
