<?php

class PartyEmailController extends \PartyLocatorController {

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
			'crumbs' => Breadcrumbs::render('party_emails', $party),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_emails.index', $aViewData);
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
			'email' => new PartyEmail,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.create'), 'party_emails', $party),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_emails.create', $aViewData);
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
			$email = new PartyEmail;
			$email->party()->associate($party);

			if($email->save()) // Validated
			{
				Notification::success(Lang::get('messages.created', array('name' => Lang::choice('labels.party_email', 1))));
				return Redirect::action('PartyEmailController@index', $party->id);
			}

			// Otherwise, it failed.
			Notification::error($email->errors()->all());
			return Redirect::action('PartyEmailController@create', $party->id)
				->withErrors($email->errors()->toArray())
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
		$email = $this->load($partyId, $id);
		$party = $email->party;

		// Set up the data needed by the view(s)
		$aViewData = array(
			'email' => $email,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('party_email', $party, $email),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_emails.show', $aViewData);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($partyId, $id)
	{
		$email = $this->load($partyId, $id);
		$party = $email->party;

		// Set up the data needed by the view(s)
		$aViewData = array(
			'email' => $email,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.edit'), 'party_email', array($party, $email)),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_emails.edit', $aViewData);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($partyId, $id)
	{
		$email = $this->load($partyId, $id);
		$party = $email->party;

		if(Input::get('save') !== NULL) // save attempt
		{
			if($email->save()) // Validated and stored
			{
				Notification::success(Lang::get('messages.updated', array('name' => '#' . $email->id)));
				return Redirect::action('PartyEmailController@show', array($party->id, $email->id));
			}

			// Otherwise, it failed.
			Notification::error($email->errors()->all());
			return Redirect::action('PartyEmailController@edit', array($party->id, $email->id))
				->withErrors($email->errors()->toArray())
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
		$email = $this->load($partyId, $id);
		$party = $email->party;

		Notification::error(Lang::get('messages.deleted', array('name' => Lang::choice('labels.party_email', 1))));
		$email->delete();

		return Redirect::action('PartyEmailController@index', $party->id);
	}

	/**
	 * Loads either a party's emails or a specific link, both by ID.
	 * Spews a 404 if nothing was found.
	 * @param  int
	 * @param  int
	 */
	private function load($partyId, $id = FALSE)
	{
		$party = FALSE;
		$email = FALSE;
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
			$party = Party::has('emails')->find($partyId);

			// If there is a party and a link by the specified ID
			if($party && $email = $party->emails->find($id)) {
				$to_return = $email;
			}
		}

		$this->layout->party = $party;
		$this->layout->active_action = 'PartyEmailController@index';

		if($to_return)
		{
			return $to_return;
		}

		return App::abort(404);
	}

}
