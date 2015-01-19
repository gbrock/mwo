<?php

class UserController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
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
		$user = User::find($id);

		if(!$user)
		{
			$user = new User;
			$party = Party::find($id);

			if(!$party)
			{
				return App::abort(404);
			}
		}
		else
		{
			$party = $user->party;
		}

		// Set up the data needed by the view(s)
		$aViewData = array(
			'user' => $user,
			'party' => $party,
		);

		// Set up the breadcrumbs
		$aViewData['crumbs'] = Breadcrumbs::render('action', Lang::choice('labels.account', 1), 'party', $party);

		// Render the view
		$this->layout->content = View::make('user/show', $aViewData);	}


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
