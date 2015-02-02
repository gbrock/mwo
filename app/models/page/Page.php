<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Illuminate\Support\Str;

class Page extends Base {
    use SoftDeletingTrait;

	public function content()
    {
        return $this
        	->hasMany('PageContent');
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
	protected $fillable = array('title', 'url', 'template');

	/**
	 * The validation rules run against the input.
	 * @var array
	 */
	public $rules = array(
		'title'                => 'required|max:255',
		'url'                  => 'min:2|max:255|unique:pages',
		'template'             => 'required',
	);

	public static function boot()
	{
		parent::boot();

		self::saving(function($page)
		{
			if(!$page->url && $page->title)
			{
				$page->url = Str::slug($page->title);
				$page_base = $page->url;
				$i = 1;

				while(count(Page::where('url', '=', $page->url)->get()->toArray()) > 0)
				{
					$page->url = $page_base . '-' . $i++;
				}
			}

			$templates = Template::all();

			if(count($templates))
			{
				$templates = array_values(pairify($templates, 'key', 'key'));
				$page->addRule('template', 'in:' . implode(',', $templates));
			}

			parent::saving($page);
		});
	}

    public function getNameAttribute()
    {
    	if($this->title)
    	{
    		return $this->title;
    	}

    	return $this->url;
    }
}
