<?php

class PartyPhone extends PartyLocator {

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

	/**
	 * The FontAwesome glyphicon to be used in conjunction with this record.
	 * @var string
	 */
	public $glyphicon = 'phone';

    public function getLabelAttribute()
    {
		$lang_label = 'party_phones.format_number';
		
		if($this->extension)
		{
			$lang_label .= '_w_extension';
		}

		// Grab the formatter from our language files
		$r = Lang::get($lang_label, array(
			'number' => $this->number,
			'extension' => $this->extension,
		));

		if($this->type)
		{
			$r .= ' <span class="label label-default">' . $this->type . '</span> ';
		}

		return $r;
    }

}