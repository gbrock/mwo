<?php

class ErrorController extends \BaseController {

	public function get404()
	{
		$this->setupLayout();
		$this->layout->content = View::make('errors.missing');

		return Response::make($this->layout, 404);
	}

}
