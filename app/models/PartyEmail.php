<?php

class PartyEmail extends PartyLocator {

	/**
	 * The fields which are guarded from input (i.e. used by the system).
	 * @var array
	 */
	protected $guarded = array('id', 'party_id');

	/**
	 * The fields which may be filled.
	 * @var array
	 */
	protected $fillable = array('address');

	/**
	 * The validation rules automatically used.
	 * @var array
	 */
	public $rules = array(
		'address'				=> 'required|email|unique:party_emails,address|max:254',
	);

	//
	public function setAddressAttribute($value)
	{
		$value = strtolower($value);
		$this->attributes['address'] = $value;
	}

	/**
	 * The FontAwesome glyphicon to be used in conjunction with this record.
	 * @var string
	 */
	public $glyphicon = 'envelope-o';

	/**
	 * The fanciest way to view this record
	 */
	public function getLabelAttribute()
	{
		return $this->address;
	}

}