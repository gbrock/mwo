<?php

class PartyLocatorController extends \BaseController {

	protected $nav_controller = 'Party';

	protected $layout = 'party';
	protected $view_folder = 'party_locators';

	protected $data_key = '';
	protected $data_key_p = '';
	protected $breadcrumb_name = '';
	protected $model_name = '';
	

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
			'page_title' => Lang::get('common.items_by_category_specified', array(
				'x' => Lang::choice('labels.party_' . $this->data_key, 0),
				'y' => Lang::choice('labels.party', 1),
				'z' => $party->name,
			)),
			'party' => $party,
			'crumbs' => Breadcrumbs::render('party_locators', $this->breadcrumb_name, $party),
			'controller' => get_class($this),
			'data_key' => $this->data_key,
			'data_key_p' => $this->data_key_p,
			'items' => $party->{$this->data_key_p},
		);

		View::share($aViewData);

		// Render the view
		$this->loadView($this->view_folder . '.index', $aViewData);
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
			'page_title' => Lang::get('labels.create_item', array('item' => Lang::choice('labels.party_' . $this->data_key, 1))),
			'party' => $party,
			$this->data_key => new $this->model_name,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.create'), 'party_locators', array($this->breadcrumb_name, $party)),
			'controller' => get_class($this),
			'data_key' => $this->data_key,
			'data_key_p' => $this->data_key_p,
			'items' => $party->{$this->data_key_p},
		);

		View::share($aViewData);

		// Render the view
		$this->loadView($this->view_folder . '.create', $aViewData);
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
			$locator = new $this->model_name;
			$locator->party()->associate($party);

			if($locator->save()) // Validated
			{
				Notification::success(Lang::get('messages.created', array('name' => $locator->label)));
				return Redirect::action(get_class($this) . '@index', $party->id);
			}

			// Otherwise, it failed.
			Notification::error($locator->errors()->all());
			return Redirect::action(get_class($this) . '@create', $party->id)
				->withErrors($locator->errors()->toArray())
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
		$locator = $this->load($partyId, $id);
		$party = $locator->party;

		// Set up the data needed by the view(s)
		$aViewData = array(
			$this->data_key => $locator,
			'page_title' => Lang::get('labels.record_id', array('type' => Lang::choice('labels.party_' . $this->data_key, 1), 'id' => $locator->id)),
			'party' => $party,
			'crumbs' => Breadcrumbs::render('party_locator', $this->breadcrumb_name, $party, $locator),
			'controller' => get_class($this),
			'data_key' => $this->data_key,
			'data_key_p' => $this->data_key_p,
			'items' => $party->{$this->data_key_p},
			'target' => $locator,
		);

		View::share($aViewData);

		// Render the view
		$this->loadView($this->view_folder . '.show', $aViewData);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($partyId, $id)
	{
		$locator = $this->load($partyId, $id);
		$party = $locator->party;

		// Set up the data needed by the view(s)
		$aViewData = array(
			$this->data_key => $locator,
			'page_title' => Lang::get('labels.edit_item', array('item' => Lang::get('labels.record_id', array('type' => Lang::choice('labels.party_' . $this->data_key, 1), 'id' => $locator->id)))),
			'party' => $party,
			'crumbs' => Breadcrumbs::render('action', Lang::get('labels.edit'), 'party_locator', array($this->breadcrumb_name, $party, $locator)),
			'controller' => get_class($this),
			'data_key' => $this->data_key,
			'data_key_p' => $this->data_key_p,
			'items' => $party->{$this->data_key_p},
			'target' => $locator,
		);

		View::share($aViewData);

		// Render the view
		$this->loadView($this->view_folder . '.edit', $aViewData);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($partyId, $id)
	{
		$locator = $this->load($partyId, $id);
		$party = $locator->party;

		if(Input::get('save') !== NULL) // save attempt
		{
			if($locator->save()) // Validated and stored
			{
				Notification::success(Lang::get('messages.updated', array('name' => $locator->label)));
				return Redirect::action(get_class($this) . '@show', array($party->id, $locator->id));
			}

			// Otherwise, it failed.
			Notification::error($locator->errors()->all());
			return Redirect::action(get_class($this) . '@edit', array($party->id, $locator->id))
				->withErrors($locator->errors()->toArray())
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
		$locator = $this->load($partyId, $id);
		$party = $locator->party;

		Notification::error(Lang::get('messages.deleted', array('name' => $locator->label)));
		$locator->delete();

		return Redirect::action(get_class($this) . '@index', $party->id);
	}

	/**
	 * Loads either a party's locators or a specific link, both by ID.
	 * Spews a 404 if nothing was found.
	 * @param  int
	 * @param  int
	 */
	private function load($partyId, $id = FALSE)
	{
		$party = FALSE;
		$locator = FALSE;
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
			$party = Party::has($this->data_key_p)->find($partyId);

			// If there is a party and a link by the specified ID
			if($party && $locator = $party->{$this->data_key_p}->find($id)) {
				$to_return = $locator;
			}
		}

		$this->layout->party = $party;
		$this->layout->active_action = get_class($this) . '@index';

		if($to_return)
		{
			return $to_return;
		}

		return App::abort(404);
	}
}
