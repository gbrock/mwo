<?php namespace Gbrock\Sentry;

use Cartalyst\Sentry\Users\Eloquent\Provider as BaseProvider;
use Cartalyst\Sentry\Hashing\HasherInterface;
use Cartalyst\Sentry\Groups\GroupInterface;
use Cartalyst\Sentry\Users\ProviderInterface;
use Cartalyst\Sentry\Users\UserInterface;

class UserProvider extends BaseProvider {
	
	/**
	 * Create a new Eloquent User provider.
	 *
	 * @param  \Cartalyst\Sentry\Hashing\HasherInterface  $hasher
	 * @param  string  $model
	 * @return void
	 */
	public function __construct(HasherInterface $hasher, $model = null)
	{
		parent::__construct($hasher, $model);
	}
}
