<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Party extends Base {
    use SoftDeletingTrait;

    protected $table = 'parties';

	public function organization()
    {
        return $this
        	->hasOne('Organization');
    }

	public function person()
    {
        return $this
        	->hasOne('Person');
    }

	public function user()
    {
        return $this
        	->hasOne('User');
    }

	public function links()
    {
        return $this
        	->hasMany('PartyLink');
    }

	public function emails()
    {
        return $this
        	->hasMany('PartyEmail');
    }

	public function phones()
    {
        return $this
        	->hasMany('PartyPhone');
    }

	public function addresses()
    {
        return $this
        	->hasMany('PartyAddress');
    }

	/**
	 * Model hooks.
	 */
	public static function boot()
	{
		parent::boot();
	}

	/**
	 * The fields which are guarded from input (i.e. used by the system).
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
		'type'                  => 'required|in:p,o',
		'name'                  => 'required|between:2,255',
	);

	public function getIconAttribute()
	{
		$icon = 'exclamation'; // Whoa, how did this happen?

		switch($this->type)
		{
			case 'p':
				$icon = 'user';
				break;
			case 'o':
				$icon = 'briefcase';
				break;
		}

		return $icon;
	}

	public function isPerson()
	{
		return $this->type === 'p';
	}

	public function isOrganization()
	{
		return $this->type === 'o';
	}
}
