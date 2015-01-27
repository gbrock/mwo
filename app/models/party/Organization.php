<?php

use Carbon\Carbon;

/**
* A business-type Party.
*/
class Organization extends PartyType {
	
	/**
	 * The fields which are guarded from input (i.e. used by the system).
	 * @var array
	 */
	protected $guarded = array('party_id');

	/**
	 * The fields which may be filled.
	 * @var array
	 */
	protected $fillable = array('founded');

	/**
	 * The validation rules automatically used.
	 *
	 * @var array
	 */
	public $rules = array(
		'founded'					=> 'date',
	);

	public function getFoundedAttribute($value)
	{
		if($value)
		{
			return new Carbon($value);
		}

		return $value;
	}

	public function getIconAttribute()
	{
		return 'briefcase';
	}
}
