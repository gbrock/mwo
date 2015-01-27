<?php

class ErrorController extends \BaseController {

	protected $layout = 'master';

	public function get404()
	{
		$this->setupLayout();
		$this->layout->rendered_view = View::make('errors.missing');

		return Response::make($this->layout, 404);
	}

	public function get405()
	{
		$this->setupLayout();
		$this->layout->rendered_view = View::make('errors.bad_method');

		return Response::make($this->layout, 405);
	}

}
