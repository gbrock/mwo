<?php

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait AS StaplerEloquence;

class User extends UserBase implements StaplerableInterface {

	use StaplerEloquence;

	protected $validateOnSave = FALSE;
	protected $autoHydrate = FALSE;
	
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

	protected $fillable = array(
		'avatar',
	);

	protected $hidden = array(
		'password',
		'reset_password_code',
		'activation_code',
		'persist_code',
		'party_id',
	);

	/**
	 * The validation rules run against the input.
	 * @var array
	 */
	protected $rules = array(
		'password'                  => 'required|confirmed',
		'avatar'                  	=> 'image',
	);
	
    public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('avatar', [
            'styles' => [
	            'medium' => '400x400#',
	            'thumb' => '96x96#',
            ]
        ]);

        parent::__construct($attributes);
    }

    public static function boot()
	{
	    parent::boot();
	    static::bootStapler();
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

	public function validate($values = FALSE)
	{
		if($this->autoHydrate)
		{
			$this->fill(Input::all());
		}

		if($this->rules)
		{
			$forced_addins = array(
				'password' => Input::get('password'),
				'password_confirmation' => Input::get('password_confirmation'),
			);
			$this->validator = Validator::make(array_merge($values ? $values : $this->toArray(), $forced_addins), $this->rules, $this->messages);
			return $this->validator->passes();
		}

		return FALSE;
	}

	protected function getIdAttribute()
	{
		return $this->party_id;
	}
}
