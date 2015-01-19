<?php

class PartyLinkController extends \BaseController {

	protected $nav_controller = 'Party';

	protected $layout = 'party';

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
			'crumbs' => Breadcrumbs::render('party_links', $party),
		);

		View::share($aViewData);

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
		$party = $this->load($partyId);

		// Set up the data needed by the view(s)
		$aViewData = array(
			'party' => $party,
			'link' => new PartyLink,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.create'), 'party_links', $party),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_links.create', $aViewData);
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
		$link = $this->load($partyId, $id);
		$party = $link->party;

		// Set up the data needed by the view(s)
		$aViewData = array(
			'link' => $link,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('party_link', $party, $link),
		);

		View::share($aViewData);

		// Render the view
		$this->layout->content = View::make('party_links.show', $aViewData);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($partyId, $id)
	{
		$link = $this->load($partyId, $id);
		$party = $link->party;

		// Set up the data needed by the view(s)
		$aViewData = array(
			'link' => $link,
			'party' => $party,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.edit'), 'party_link', array($party, $link)),
		);

		View::share($aViewData);

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
		$link = $this->load($partyId, $id);
		$party = $link->party;

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
		$link = $this->load($partyId, $id);
		$party = $link->party;

		Notification::error(Lang::get('messages.deleted', array('name' => Lang::choice('labels.party_link', 1))));
		$link->delete();

		return Redirect::action('PartyLinkController@index', $party->id);
	}

	/**
	 * Loads either a party's links or a specific link, both by ID.
	 * Spews a 404 if nothing was found.
	 * @param  int
	 * @param  int
	 */
	private function load($partyId, $id = FALSE)
	{
		$party = FALSE;
		$link = FALSE;
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
			$party = Party::has('links')->find($partyId);

			// If there is a party and a link by the specified ID
			if($party && $link = $party->links->find($id)) {
				$to_return = $link;
			}
		}

		$this->layout->party = $party;
		$this->layout->active_action = 'PartyLinkController@index';

		if($to_return)
		{
			return $to_return;
		}

		return App::abort(404);
	}

}
