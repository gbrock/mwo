<?php
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait AS StaplerEloquence;

class PageContent extends Base implements StaplerableInterface {

	use StaplerEloquence;

	protected $validateOnSave = FALSE;
	protected $autoHydrate = FALSE;

	public function page()
    {
        return $this
        	->belongsTo('Page');
    }

	/**
	 * The fields which are guarded from input (i.e. used by the system).
	 * @var array
	 */
	protected $guarded = array('id', 'page_id');

	/**
	 * The fields which may be filled.
	 * @var array
	 */
	protected $fillable = array('key', 'value');

    /**
     * Whether timestamps should be autmatically generated.
     */
    public $timestamps = FALSE;

	/**
	 * The validation rules run against the input.
	 * @var array
	 */
	public $rules = array(
	);

	public function __construct(array $attributes = array()) {
        $this->hasAttachedFile('image', [
            'styles' => []
        ]);

        parent::__construct($attributes);
    }

}
