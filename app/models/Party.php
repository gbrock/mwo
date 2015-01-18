<?php

/**
* 
*/
class Party extends Base
{
	/**
	 * The database table.  We use singular form.
	 * @var string
	 */
	protected $table = 'party';

	/**
	 * The fields which are not guarded from input (i.e. used by the system).
	 * @var array
	 */
	protected $guarded = array('id', 'created_at', 'updated_at');

	/**
	 * The fields which may be filled.
	 * @var array
	 */
	protected $fillable = array('name', 'type');

	/**
	 * The validation rules run against the input.
	 * @var array
	 */
	public $rules = array(
		'type'                  => 'required|in:i,o',
		'name'                  => 'required|between:2,255',
	);
}
