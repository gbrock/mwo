<?php

use Illuminate\Support\Collection;

class BaseController extends Controller {

	protected $layout = 'master';
	protected $asset_folder = 'includes';

	protected $css = array();
	protected $js = array();

	public function __construct()
	{
		$this->css = new Collection($this->css);
		$this->js = new Collection($this->js);

		$this->css->push('screen.css');
		$this->js->push('bootstrap.js');
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
			$this->layout = View::make('layouts.' . $this->layout, array(
				'script_base' => $this->asset_folder . '/js',
				'style_base' => $this->asset_folder . '/css',
				'css' => $this->css->toArray(),
				'js' => $this->js->toArray(),
			));
		}
	}

}
