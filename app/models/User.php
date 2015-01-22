<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel {

    use SoftDeletingTrait;
	
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

	// protected static function boot()
	// {
	// 	parent::boot();

	// 	static::addGlobalScope(new RequireEmailScope);
	// }

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

    public function scopeWithEmails($query)
    {
    	$email = new PartyEmail;
        return $query->join(
			$email->getTable(),
			$email->getTable() . '.' . 'party_id',
			'=',
			$this->getTable() . '.' . 'party_id'
		);
    }

	/**
	 * Validates the user and throws a number of
	 * Exceptions if validation fails.
	 *
	 * @return bool
	 * @throws \Cartalyst\Sentry\Users\LoginRequiredException
	 * @throws \Cartalyst\Sentry\Users\PasswordRequiredException
	 * @throws \Cartalyst\Sentry\Users\UserExistsException
	 */
	public function validate()
	{
		if ( ! $login = $this->{static::$loginAttribute})
		{
			throw new Cartalyst\Sentry\Users\LoginRequiredException("A login is required for a user, none given.");
		}

		if ( ! $password = $this->getPassword())
		{
			throw new Cartalyst\Sentry\Users\PasswordRequiredException("A password is required for user [$login], none given.");
		}

		// Check if the user already exists
		$query = $this->newQuery();
		$persistedUser = $query->where($this->getLoginName(), '=', $login)->first();

		if ($persistedUser and $persistedUser->getId() != $this->getId())
		{
			throw new Cartalyst\Sentry\Users\UserExistsException("A user already exists with login [$login], logins must be unique for users.");
		}

		return true;
	}

}
