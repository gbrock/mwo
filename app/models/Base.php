<?php

class Base extends Eloquent {
	/**
	 * The rules passed to Validate.
	 * @var array
	 */
	protected $rules = array();
	/**
	 * The custom messages passed to Validate.
	 * @var array
	 */
	protected $messages = array();

	/**
	 * Whether Validate should be called on save()
	 * @var boolean
	 */
	protected $validateOnSave = TRUE;
	protected $autoHydrate = TRUE;

	private $validator;

	public static function boot()
	{
		parent::boot();

		static::saving(function($model) {
			if($model->validateOnSave && !$model->validate())
			{
				return FALSE;
			}
			
			static::trimStrings($model);
			static::setNullWhenEmpty($model);
			return TRUE;
		});
	}

	public function validate()
	{
		if($this->autoHydrate)
		{
			$this->hydrate();
		}

		if($this->rules)
		{
			$this->validator = Validator::make($this->toArray(), $this->rules, $this->messages);
			return $this->validator->passes();
		}

		return FALSE;
	}

	public function passed()
	{
		return $this->validator->passed();
	}

	public function failed()
	{
		return $this->validator->failed();
	}

	public function errors()
	{
		return $this->validator->errors();
	}

	public function hydrate()
	{
		$this->fill(Input::all());
	}

	/**
	 * Sets all fields which correspond to empty() are set to NULL.
	 * @param  Base
	 */
	protected static function setNullWhenEmpty($model)
	{
		foreach ($model->toArray() as $name => $value) {
			switch(TRUE)
			{
				case empty($value):
					$model->{$name} = null;
					break;
			}
		}
	}

	/**
	 * Trims whitespace and removes double whitespace from strings.
	 * @param  Base
	 */
	protected static function trimStrings($model)
	{
		foreach ($model->toArray() as $name => $value) {
			if(is_string($value))
			{
				$model->{$name} = trim(preg_replace('/\s+/', ' ', $value));
			}
		}
	}
}
