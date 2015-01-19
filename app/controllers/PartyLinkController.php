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
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($partyId, $id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($partyId, $id)
	{
		//
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
