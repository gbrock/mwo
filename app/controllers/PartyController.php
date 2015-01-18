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

		// Set up the data needed by the view(s)
		$aViewData = array();

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
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
