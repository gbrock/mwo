<?php

class PageController extends \BaseController {

	protected $layout = 'admin';

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
		$pages = Page::paginate($iLimit);

		// Set up the data needed by the view(s)
		$aViewData = array(
			'page_title' => Lang::choice('labels.page', 0),
			'crumbs' => Breadcrumbs::render('pages'),
		);

		View::share($aViewData);

		$aViewData['records'] = $pages;
		$aViewData['sort_url'] = 'directory?';

		// Render the view
		$this->loadView('pages.index', $aViewData);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$selected_template = Input::old('template', 'default');

		// Set up the data needed by the view(s)
		$aViewData = array(
			'page_title' => Lang::get('pages.create'),
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.create'), 'pages'),
		);

		View::share($aViewData);

		$aViewData['templates'] = Template::all();
		$aViewData['selected_template'] = $selected_template;

		// Render the view
		$this->loadView('pages/create', $aViewData);
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

		}
		elseif(Input::get('template') !== NULL)
		{
			return Redirect::action('PageController@create')
				->withInput();
		}

		// If we got this far, the request failed.
		App::abort(404);
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
