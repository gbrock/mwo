<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {

    use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user';
	
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

	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new RequireEmailScope);
	}

    /**
     * The main parent relationship to Party.
     */
	public function party()
    {
        return $this
        	->belongsTo('Party');
    }

    /**
     * The main parent relationship to Party.
     */
	public function emails()
    {
        return $this
        	->hasMany('PartyEmail', 'party_id');
    }

}
