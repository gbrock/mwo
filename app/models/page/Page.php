<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Page extends Base {
    use SoftDeletingTrait;

	public function content()
    {
        return $this
        	->hasMany('PageContents');
    }

	/**
	 * The fields which are guarded from input (i.e. used by the system).
	 * @var array
	 */
	protected $guarded = array('id', 'created_at', 'updated_at', 'deleted_at');

	/**
	 * The fields which may be filled.
	 * @var array
	 */
	protected $fillable = array('url', 'template');

	/**
	 * The validation rules run against the input.
	 * @var array
	 */
	public $rules = array(
		'url'                  => 'required|min:2|max:255',
		'template'             => 'required',
	);

    public function getNameAttribute()
    {
    	if($this->title)
    	{
    		return $this->title;
    	}

    	return $this->url;
    }
}
