<?php

trait ValidatingTrait {

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

	protected $validator;

	public static function boot()
	{
		parent::boot();

		static::saving(function($model) {
			if($model->validateOnSave)
			{
				if(!$model->validate())
				{
					return FALSE;
				}

				static::trimStrings($model);
				static::setNullWhenEmpty($model);
			}
		});
	}

	public function validate($values = FALSE)
	{
		if($this->autoHydrate)
		{
			$this->fill(Input::all());
		}

		if($this->rules)
		{
			$this->validator = Validator::make($values ? $values : $this->toArray(), $this->rules, $this->messages);
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

	
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    /**
     * Adds a validation rule to a rule set.
     * @param  string $field
     * @param  string $rule 
     */
    public function addRule($field, $rule, $value = NULL)
    {
    	$rules = $this->getRules($field);

    	$rules[$rule] = $value;

    	$this->setRules($field, $rules);
    }

    /**
     * Removes a validation rule from a rule set.
     * @param  string $field
     * @param  string $rule 
     */
    public function removeRule($field, $rule)
    {
    	$rules = $this->getRules($field);

		unset($rules[$rule]);

    	$this->setRules($field, $rules);
    }

    /**
     * Sets the field's rules to the given rule array, overwriting old rules.
     * @param string $field
     * @param array $rules
     */
    protected function setRules($field, $rules)
    {
    	$new_rules = array();
    	foreach($rules as $k => $v)
    	{
    		if($v === NULL)
    		{
				$new_rules[] = $k;
    		}
    		else
    		{
    			$new_rules[] = $k . ':' . (is_array($v) ? implode(',', $v) : $v);
    		}
    	}

    	$this->rules[$field] = implode('|', $new_rules);
    }

    /**
     * Retrieves the validation rules for a given field.
     * @param  string $field
     * @return array
     */
    public function getRules($field)
    {
    	$r = array();
    	if(isset($this->rules[$field]))
    	{
	    	$a = explode('|', $this->rules[$field]);

	    	if(count($a))
	    	{
	    		foreach($a as $v)
	    		{
		    		$e = explode(':', $v);
	    			$r[$e[0]] = (isset($e[1]) ? $e[1] : NULL);
	    		}
	    	}
    	}

    	return $r;
    }
}
