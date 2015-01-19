<?php

class PartyAddressController extends \PartyLocatorController {

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
			'crumbs' => Breadcrumbs::render('party_addresses', $party),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_addresses.index', $aViewData);
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
			'address' => new PartyAddress,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.create'), 'party_addresses', $party),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_addresses.create', $aViewData);
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
			$address = new PartyAddress;
			$address->party()->associate($party);

			if($address->save()) // Validated
			{
				Notification::success(Lang::get('messages.created', array('name' => Lang::choice('labels.party_address', 1))));
				return Redirect::action('PartyAddressController@index', $party->id);
			}

			// Otherwise, it failed.
			Notification::error($address->errors()->all());
			return Redirect::action('PartyAddressController@create', $party->id)
				->withErrors($address->errors()->toArray())
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
		$address = $this->load($partyId, $id);
		$party = $address->party;

		// Set up the data needed by the view(s)
		$aViewData = array(
			'address' => $address,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('party_address', $party, $address),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_addresses.show', $aViewData);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($partyId, $id)
	{
		$address = $this->load($partyId, $id);
		$party = $address->party;

		// Set up the data needed by the view(s)
		$aViewData = array(
			'address' => $address,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.edit'), 'party_address', array($party, $address)),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_addresses.edit', $aViewData);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($partyId, $id)
	{
		$address = $this->load($partyId, $id);
		$party = $address->party;

		if(Input::get('save') !== NULL) // save attempt
		{
			if($address->save()) // Validated and stored
			{
				Notification::success(Lang::get('messages.updated', array('name' => '#' . $address->id)));
				return Redirect::action('PartyAddressController@show', array($party->id, $address->id));
			}

			// Otherwise, it failed.
			Notification::error($address->errors()->all());
			return Redirect::action('PartyAddressController@edit', array($party->id, $address->id))
				->withErrors($address->errors()->toArray())
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
		$address = $this->load($partyId, $id);
		$party = $address->party;

		Notification::error(Lang::get('messages.deleted', array('name' => Lang::choice('labels.party_address', 1))));
		$address->delete();

		return Redirect::action('PartyAddressController@index', $party->id);
	}

	/**
	 * Loads either a party's addresses or a specific link, both by ID.
	 * Spews a 404 if nothing was found.
	 * @param  int
	 * @param  int
	 */
	private function load($partyId, $id = FALSE)
	{
		$party = FALSE;
		$address = FALSE;
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
			$party = Party::has('addresses')->find($partyId);

			// If there is a party and a link by the specified ID
			if($party && $address = $party->addresses->find($id)) {
				$to_return = $address;
			}
		}

		$this->layout->party = $party;
		$this->layout->active_action = 'PartyAddressController@index';

		if($to_return)
		{
			return $to_return;
		}

		return App::abort(404);
	}

}
