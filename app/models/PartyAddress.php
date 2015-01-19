<?php

class PartyAddress extends PartyLocator {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'party_location';

	protected $guarded = array('id', 'party_id');
	protected $fillable = array('provided_as', 'type');

	/**
	 * The validation rules automatically used.
	 *
	 * @var array
	 */
	public $rules = array(
		'provided_as'				=> 'required',
		'type' 						=> 'max:24',
	);

}