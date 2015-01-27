<?php namespace Gbrock\Sentry;

use Gbrock\Sentry\UserProvider as UserProvider;
use Cartalyst\Sentry\SentryServiceProvider as Sentry;

class SentryServiceProvider extends Sentry {

	/**
	 * Boot the service provider.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('cartalyst/sentry', 'cartalyst/sentry', base_path('vendor/cartalyst/sentry/src'));
	}

	/**
	 * Register the user provider used by Sentry.
	 *
	 * @return void
	 */
	protected function registerUserProvider()
	{
		$this->app['sentry.user'] = $this->app->share(function($app)
		{
			$model = $app['config']['cartalyst/sentry::users.model'];

			// We will never be accessing a user in Sentry without accessing
			// the user provider first. So, we can lazily set up our user
			// model's login attribute here. If you are manually using the
			// attribute outside of Sentry, you will need to ensure you are
			// overriding at runtime.
			if (method_exists($model, 'setLoginAttributeName'))
			{
				$loginAttribute = $app['config']['cartalyst/sentry::users.login_attribute'];

				forward_static_call_array(
					array($model, 'setLoginAttributeName'),
					array($loginAttribute)
				);
			}

			// Define the Group model to use for relationships.
			if (method_exists($model, 'setGroupModel'))
			{
				$groupModel = $app['config']['cartalyst/sentry::groups.model'];

				forward_static_call_array(
					array($model, 'setGroupModel'),
					array($groupModel)
				);
			}

			// Define the user group pivot table name to use for relationships.
			if (method_exists($model, 'setUserGroupsPivot'))
			{
				$pivotTable = $app['config']['cartalyst/sentry::user_groups_pivot_table'];

				forward_static_call_array(
					array($model, 'setUserGroupsPivot'),
					array($pivotTable)
				);
			}

			return new UserProvider($app['sentry.hasher'], $model);
		});
	}

}
