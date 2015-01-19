<?php

class PartyLink extends PartyLocator {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'party_link';

	protected $guarded = array('id', 'party_id');
	protected $fillable = array('url');

	/**
	 * The validation rules automatically used.
	 *
	 * @var array
	 */
	public $rules = array(
		'url'				=> 'required',
	);

	public function getUrlAttribute($value)
	{
		$scheme = 'http://';

		if(!empty($value))
		{
			$prepped = HTML::prep_url($value, $scheme);

			if($prepped !== $scheme) // Make sure it still isn't empty
			{
				return $prepped;
			}
		}

		return '';
	}

	/**
	 * The FontAwesome glyphicon to be used in conjunction with this record.
	 * @var string
	 */
	public $glyphicon = 'link';

    public function getLabelAttribute()
    {
		return $this->url;
    }

}