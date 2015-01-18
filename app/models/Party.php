<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Party extends Base
{
    use SoftDeletingTrait;

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

	/**
	 * Model hooks.
	 */
	public static function boot()
	{
		parent::boot();

		static::created(function($model) {
			switch($model->type)
			{
				case 'p':
					$person = new Person;
					$person->party()->associate($model);
					return $person->save();
					break;
				case 'o':
					$organization = new Organization;
					$organization->party()->associate($model);
					return $organization->save();
					break;
			}

			// We must save a Type record.
			return FALSE;
		});
	}

	/**
	 * The database table.  We use singular form.
	 * @var string
	 */
	protected $table = 'party';

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
}