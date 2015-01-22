<?php

class PartyAddress extends PartyLocator {

	/**
	 * The fields which are guarded from input (i.e. used by the system).
	 * @var array
	 */
	protected $guarded = array('id', 'party_id');

	/**
	 * The fields which may be filled.
	 * @var array
	 */
	protected $fillable = array('provided_as', 'type');

	/**
	 * The validation rules automatically used.
	 * @var array
	 */
	public $rules = array(
		'provided_as'				=> 'required',
		'type' 						=> 'max:24',
	);

	/**
	 * The FontAwesome glyphicon to be used in conjunction with this record.
	 * @var string
	 */
	public $glyphicon = 'map-marker';

	/**
	 * The fanciest way to view this record
	 * @var string
	 */
	public function getLabelAttribute()
	{
		return $this->provided_as;
	}

}