<?php

class PartyPhoneController extends \PartyLocatorController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($partyId)
	{
		$party = $this->load($partyId);

		// Set up the data needed by the view(s)
		$aViewData = array(
			'party' => $party,
			'crumbs' => Breadcrumbs::render('party_phones', $party),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_phones.index', $aViewData);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($partyId)
	{
		$party = $this->load($partyId);

		// Set up the data needed by the view(s)
		$aViewData = array(
			'party' => $party,
			'phone' => new PartyPhone,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.create'), 'party_phones', $party),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_phones.create', $aViewData);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($partyId)
	{
		$party = $this->load($partyId);

		if(Input::get('save') !== NULL) // save attempt
		{
			$phone = new PartyPhone;
			$phone->party()->associate($party);

			if($phone->save()) // Validated
			{
				Notification::success(Lang::get('messages.created', array('name' => Lang::choice('labels.party_phone', 1))));
				return Redirect::action('PartyPhoneController@index', $party->id);
			}

			// Otherwise, it failed.
			Notification::error($phone->errors()->all());
			return Redirect::action('PartyPhoneController@create', $party->id)
				->withErrors($phone->errors()->toArray())
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
	public function show($partyId, $id)
	{
		$phone = $this->load($partyId, $id);
		$party = $phone->party;

		// Set up the data needed by the view(s)
		$aViewData = array(
			'phone' => $phone,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('party_phone', $party, $phone),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_phones.show', $aViewData);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($partyId, $id)
	{
		$phone = $this->load($partyId, $id);
		$party = $phone->party;

		// Set up the data needed by the view(s)
		$aViewData = array(
			'phone' => $phone,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.edit'), 'party_phone', array($party, $phone)),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_phones.edit', $aViewData);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($partyId, $id)
	{
		$phone = $this->load($partyId, $id);
		$party = $phone->party;

		if(Input::get('save') !== NULL) // save attempt
		{
			if($phone->save()) // Validated and stored
			{
				Notification::success(Lang::get('messages.updated', array('name' => '#' . $phone->id)));
				return Redirect::action('PartyPhoneController@show', array($party->id, $phone->id));
			}

			// Otherwise, it failed.
			Notification::error($phone->errors()->all());
			return Redirect::action('PartyPhoneController@edit', array($party->id, $phone->id))
				->withErrors($phone->errors()->toArray())
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
	public function destroy($partyId, $id)
	{
		$phone = $this->load($partyId, $id);
		$party = $phone->party;

		Notification::error(Lang::get('messages.deleted', array('name' => Lang::choice('labels.party_phone', 1))));
		$phone->delete();

		return Redirect::action('PartyPhoneController@index', $party->id);
	}

	/**
	 * Loads either a party's phones or a specific link, both by ID.
	 * Spews a 404 if nothing was found.
	 * @param  int
	 * @param  int
	 */
	private function load($partyId, $id = FALSE)
	{
		$party = FALSE;
		$phone = FALSE;
		$to_return = FALSE;

		if(!$id)
		{
			// Get party by ID
			$party = Party::all()->find($partyId);

			// If party was found
			if($party) {
				$to_return = $party;
			}

		}
		else
		{
			// Get party by ID which has links
			$party = Party::has('phones')->find($partyId);

			// If there is a party and a link by the specified ID
			if($party && $phone = $party->phones->find($id)) {
				$to_return = $phone;
			}
		}

		$this->layout->party = $party;
		$this->layout->active_action = 'PartyPhoneController@index';

		if($to_return)
		{
			return $to_return;
		}

		return App::abort(404);
	}

}
