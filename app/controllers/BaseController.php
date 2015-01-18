<?php

use Illuminate\Support\Collection;

class BaseController extends Controller {

	protected $nav_controller;

	protected $layout = 'master';
	protected $asset_folder = 'includes';

	protected $css = array();
	protected $js = array();

	protected $page_record_limit = 100;

	public function __construct()
	{
		$this->css = new Collection($this->css);
		$this->js = new Collection($this->js);

		$this->css->push('screen.css');

		if(!$this->nav_controller)
		{
			$this->nav_controller = substr_replace(get_class($this), '', -strlen('Controller'));
		}

		// Let's see how long until we need JS.
		// $this->js->push('jquery.js');
		// $this->js->push('bootstrap.js');
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			// Share the current controller throughout our views
			View::share('active_controller', $this->nav_controller . 'Controller');

			$this->layout = View::make('layouts.' . $this->layout, array(
				'script_base' => $this->asset_folder . '/js',
				'style_base' => $this->asset_folder . '/css',
				'css' => $this->css->toArray(),
				'js' => $this->js->toArray(),
			));
		}
	}

	protected function getLimit()
	{
		// The index defaults
		$iDefaultLimit = 10;
		$iMaxLimit = (int) $this->page_record_limit;

		// Sanity check; table max must be at least global default max
		$iMaxLimit = max($iMaxLimit, $iDefaultLimit);
		
		// Limit is either &_GET['limit'] or default, whichever is higher
		$iLimit = max((int) Input::get('limit'), $iDefaultLimit);

		// Don't let the limit go above max
		$iLimit = min($iLimit, $iMaxLimit);

		return $iLimit;
	}

}
