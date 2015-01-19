<?php

class PartyLinkController extends \BaseController {

	protected $nav_controller = 'Party';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($partyId)
	{
		$party = Party::with('links')->find($partyId);

		if(!$party) {
			return App::abort(404);
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'party' => $party,
		);

		// Set up the breadcrumbs
		$aViewData['crumbs'] = Breadcrumbs::render('party_links', $party);

		// Render the view
		$this->layout->content = View::make('party_links.index', $aViewData);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($partyId)
	{
		$party = Party::with('links')->find($partyId);

		if(!$party) {
			return App::abort(404);
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'party' => $party,
			'link' => new PartyLink,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.create'), 'party_links', $party),
			'active_action' => 'PartyLinkController@index',
		);

		// Set up the form to post
		View::share('form_action', array('PartyLinkController@store', $party->id));

		// Render the view
		$this->layout->content = View::make('party_links/create', $aViewData);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($partyId)
	{
		$party = Party::with('links')->find($partyId);

		if(!$party) {
			return App::abort(404);
		}

		if(Input::get('save') !== NULL) // save attempt
		{
			$link = new PartyLink;
			$link->party()->associate($party);

			if($link->save()) // Validated
			{

				Notification::success(Lang::get('messages.created', array('name' => Lang::choice('labels.party_link', 1))));
				return Redirect::action('PartyLinkController@index', $party->id);
			}

			// Otherwise, it failed.
			Notification::error($link->errors()->all());
			return Redirect::action('PartyLinkController@create', $party->id)
				->withErrors($link->errors()->toArray())
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
		// Get party by ID which has links
		$party = Party::has('links')->find($partyId);

		// If there was no party, or no link by the specified ID
		if(!$party || !$link = $party->links->find($id)) {
			return App::abort(404);
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'link' => $link,
			'party' => $link->party,
			'crumbs' => Breadcrumbs::render('party_link', $party, $link),
			'active_action' => 'PartyLinkController@index',
		);

		// Render the view
		$this->layout->content = View::make('party_links/show', $aViewData);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($partyId, $id)
	{
		// Get party by ID which has links
		$party = Party::has('links')->find($partyId);

		// If there was no party, or no link by the specified ID
		if(!$party || !$link = $party->links->find($id)) {
			return App::abort(404);
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'link' => $link,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.edit'), 'party_link', array($party, $link)),
			'active_action' => 'PartyLinkController@index',
		);

		// Set up the form to post
		View::share('form_action', array('PartyLinkController@update', array($party->id, $link->id)));

		// Render the view
		$this->layout->content = View::make('party_links.edit', $aViewData);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($partyId, $id)
	{
		// Get party by ID which has links
		$party = Party::has('links')->find($partyId);

		// If there was no party, or no link by the specified ID
		if(!$party || !$link = $party->links->find($id)) {
			return App::abort(404);
		}

		if(Input::get('save') !== NULL) // save attempt
		{
			if($link->save()) // Validated and stored
			{
				Notification::success(Lang::get('messages.updated', array('name' => '#' . $link->id)));
				return Redirect::action('PartyLinkController@show', array($party->id, $link->id));
			}

			// Otherwise, it failed.
			Notification::error($link->errors()->all());
			return Redirect::action('PartyLinkController@edit', array($party->id, $link->id))
				->withErrors($link->errors()->toArray())
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
		// Get party by ID which has links
		$party = Party::has('links')->find($partyId);

		// If there was no party, or no link by the specified ID
		if(!$party || !$link = $party->links->find($id)) {
			return App::abort(404);
		}

		Notification::error(Lang::get('messages.deleted', array('name' => Lang::choice('labels.party_link', 1))));
		$link->delete();

		return Redirect::action('PartyLinkController@index', $party->id);
	}


}
