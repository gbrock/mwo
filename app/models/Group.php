<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Cartalyst\Sentry\Users\Eloquent\User as SentryGroupModel;

class Group extends SentryGroupModel {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'group';

}
