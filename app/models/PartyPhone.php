<?php

class PartyPhone extends PartyLocator {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'party_phone';

	protected $guarded = array('id', 'party_id');
	protected $fillable = array('type', 'number', 'extension');

	/**
	 * The validation rules automatically used.
	 *
	 * @var array
	 */
	public $rules = array(
		'number' =>					'required|max:64',
		'type' =>					'max:24',
		'extension' =>				'numeric',
	);

    public function setExtensionAttribute($value)
    {
    	if($value)
    	{
	        $this->attributes['extension'] = preg_replace("/[^0-9]/", "", $value);
    	}
    	else
    	{
    		$this->attributes['extension'] = NULL;
    	}
    }

}