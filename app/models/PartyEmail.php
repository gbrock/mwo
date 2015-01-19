<?php

class PartyEmail extends PartyLocator {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'party_email';

	protected $guarded = array('id', 'party_id');
	protected $fillable = array('address');

	/**
	 * The validation rules automatically used.
	 *
	 * @var array
	 */
	public $rules = array(
		'address'				=> 'required|email|max:254',
	);

	public function setAddressAttribute($value)
	{
		$value = strtolower($value);
		$this->attributes['address'] = $value;
	}

}