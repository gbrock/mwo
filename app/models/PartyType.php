<?php

class PartyType extends Base {
	
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

	/**
	 * Whether the primary key auto-increments.
	 *
	 * @var boolean
	 */
    public $incrementing = FALSE;

    /**
     * Whether timestamps should be autmatically generated.
     */
    public $timestamps = FALSE;

    /**
     * The main parent relationship to Party.
     */
	public function party()
    {
        return $this
        	->belongsTo('Party');
    }

}
