<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class UserBase extends SentryUserModel {

    use SoftDeletingTrait;
    use ValidatingTrait;

}
