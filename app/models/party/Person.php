<?php

use Carbon\Carbon;

/**
* An individual-type Party.
*/
class Person extends PartyType
{

	/**
	 * The fields which are guarded from input (i.e. used by the system).
	 * @var array
	 */
	protected $guarded = array('party_id');

	/**
	 * The fields which may be filled.
	 * @var array
	 */
	protected $fillable = array('gender', 'birth');

	/**
	 * The validation rules automatically used.
	 *
	 * @var array
	 */
	public $rules = array(
		'gender'					=> 'max:255',
		'birth'						=> 'date',
	);

	public function getBirthAttribute($value)
	{
		if($value)
		{
			return new Carbon($value);
		}

		return $value;
	}

	public function getIconAttribute()
	{
		return 'user';
	}
}
