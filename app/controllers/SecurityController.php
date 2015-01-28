<?php

class SecurityController extends \BaseController {

	/**
	 * Shows the Security dashboard.
	 */
	public function index()
	{
		$aViewData = array(
			'page_title' => Lang::get('titles.security'),
			'crumbs' => Breadcrumbs::render('security'),
		);

		View::share($aViewData);

		$this->loadView('security.index');
	}

	
}
