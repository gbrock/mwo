<?php

class User extends UserBase {

	protected $validateOnSave = FALSE;
	protected $autoHydrate = FALSE;
	
	/**
	 * Which model(s) should have their timestamps updated ON UPDATE.
	 * @var array
	 */
	protected $touches = array('party');

	/**
	 * The table's primary key.
	 *
	 * @var string
	 */
	protected $primaryKey = 'party_id';


	protected $hidden = array(
		'password',
		'reset_password_code',
		'activation_code',
		'persist_code',
		'party_id',
	);

	/**
	 * The validation rules run against the input.
	 * @var array
	 */
	protected $rules = array(
		'password'                  => 'required|confirmed',
	);

    /**
     * The main parent relationship to Party.
     */
	public function party()
    {
        return $this
        	->belongsTo('Party');
    }

    /**
     * The main parent relationship to Party.
     */
	public function emails()
    {
        return $this
        	->hasMany('PartyEmail', 'party_id');
    }

    public function scopeWithEmails($query)
    {
    	$email = new PartyEmail;
        return $query->join(
			$email->getTable(),
			$email->getTable() . '.' . 'party_id',
			'=',
			$this->getTable() . '.' . 'party_id'
		);
    }

	public function validate()
	{
		if($this->autoHydrate)
		{
			$this->fill(Input::all());
		}

		if($this->rules)
		{
			$forced_addins = array(
				'password' => Input::get('password'),
				'password_confirmation' => Input::get('password_confirmation'),
			);
			$this->validator = Validator::make(array_merge($this->toArray(), $forced_addins), $this->rules, $this->messages);
			return $this->validator->passes();
		}

		return FALSE;
	}

	protected function getIdAttribute()
	{
		return $this->party->id;
	}
}
