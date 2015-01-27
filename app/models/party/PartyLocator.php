<?php

class PartyLocator extends Base {
	
	/**
	 * Which model(s) should have their timestamps updated ON UPDATE.
	 * @var array
	 */
	protected $touches = array('party');

    /**
     * The main parent relationship to Party.
     */
	public function party()
    {
        return $this
        	->belongsTo('Party');
    }

}
