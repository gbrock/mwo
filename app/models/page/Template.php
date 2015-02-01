<?php

use Illuminate\Support\Contracts\ArrayableInterface;

class Template implements ArrayAccess, ArrayableInterface {
	private $container;
	private $location;

	function __construct()
	{
		$this->location = app_path('views/templates');
		$this->loadAll();
	}

	public static function all()
	{
		$instance = new static;

		return $instance->toArray();
	}

    private function loadAll()
    {
    	$templates = array();

    	if ($handle = opendir($this->location))
    	{
		    while (false !== ($entry = readdir($handle))) {

		        if ($entry != "." && $entry != ".." && substr($entry, -4) === 'json')
		        {
		        	$templates[] = $entry;
		        }
		    }

		    closedir($handle);
		}

		if(count($templates) > 0)
		{
			foreach($templates as $t)
			{
				$file = $this->location . '/' . $t;
				$key = substr($t, 0, strlen($t) - strlen('.json'));

				if(file_exists($file))
				{
					$json_contents = json_decode(file_get_contents($file));

					if(is_object($json_contents))
					{
						$json_contents->key = $key;
						$this[$key] = $json_contents;
					}
				}
			}
		}
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset))
        {
            $this->container[] = $value;
        }
        else
        {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function toArray()
    {
    	return $this->container;
    }
}
