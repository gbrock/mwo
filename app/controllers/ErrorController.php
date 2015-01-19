<?php

class ErrorController extends \BaseController {

	public function get404()
	{
		$this->setupLayout();
		$this->layout->content = View::make('errors.missing');

		return Response::make($this->layout, 404);
	}

	public function get405()
	{
		$this->setupLayout();
		$this->layout->content = View::make('errors.bad_method');

		return Response::make($this->layout, 405);
	}

}
