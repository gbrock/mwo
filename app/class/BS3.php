<?php

/**
 * Helper class used to generate Twitter Bootstrap 3.x elements
 */

class BS3 {

	/**
	 * Render a button.
	 * 
	 * @param  string  $url         The href attribute, if needed.
	 * @param  string  $label       The visible label.
	 * @param  string  $classes     The btn-* classes.
	 * @param  array   $passed_attr Additional attributes
	 * @return string
	 */
	public static function button($url = FALSE, $label = '', $classes = FALSE, $passed_attr = array())
	{
		// Is this button a link?
		$is_anchor = ($url ? TRUE : FALSE);
		// The btn element attributes
		$attributes = array();

		/**
		 * Automatic Class Assignment
		 * User can pass NULL to not assign any classes automatically
		 */
		if($classes !== NULL)
		{
			// If no classes we assigned, assume it should have default style
			if(!$classes)
			{
				$classes = 'default';
			}

			// If a string of classes was passed, explode it out.
			if(is_string($classes))
			{			
				$classes = array_filter(explode(' ', $classes));
			}

			if(count($classes))
			{
				foreach($classes as $k => $v)
				{
					// Prepend 'btn-' to this class if it isn't there
					if(substr($v, 0, 4) !== 'btn-') {
						$v = 'btn-' . $v;
					}

					$classes[$k] = $v;
				}
			}

			// Assign the base class and implode the others on
			$attributes['class'] = 'btn ' . implode(' ', $classes);
		}

		/**
		 * The tag used when building the element.
		 * @var string
		 */
		$tag = 'button';


		// if this is a link
		if($is_anchor)
		{
			// use an anchor tag and insert the URL as its href
			$tag = 'a';
			$attributes = array_merge($attributes, array(
				'href' => $url,
			));
		}

		return '<' . $tag . self::attribute_string($attributes, $passed_attr) . '>' . $label . '</' . $tag . '>';
	}

	/**
	 * Turns an array into an HTML attribute string.
	 * @param  mixed $attributes
	 * @return string
	 */
	protected static function attribute_string($attributes, $major_attributes = array())
	{
		// Use the second array as the primary values, if present.
		$attributes = self::merge_attributes($attributes, $major_attributes);

		if (is_string($attributes) AND strlen($attributes) > 0)
		{
			return ' '.$attributes;
		}

		if (is_object($attributes) AND count($attributes) > 0)
		{
			$attributes = (array) $attributes;
		}

		if (is_array($attributes) AND count($attributes) > 0)
		{
			$str = '';

			foreach ($attributes as $key => $val)
			{
				$str .= ' '.$key.'="'.$val.'"';
			}

			return $str;
		}
	}

	/**
	 * Return an attribute array where $b overwrites $a where present,
	 * excluding special cases.
	 * @param  array $a
	 * @param  array $b
	 * @return array
	 */
	protected static function merge_attributes($a, $b)
	{
		/**
		 * We need at least two arrays
		 */
		if(!is_array($a) || !is_array($b))
		{
			throw new Exception('BS3->merge_attributes() requires two arrays');
			return;
		}

		/**
		 * Any attribute keys found from this array will be merged instead of
		 * $b overwriting $a
		 * @var array
		 */
		$merge_attributes = array(
			'class',
		);

		if(count($merge_attributes) > 0)
		{
			foreach($merge_attributes as $attr)
			{
				// If this attr was set on both arrays, we don't want to overwrite them
				if(isset($a[$attr]) && isset($b[$attr]))
				{
					// Set $b attr to be the combination of both
					$b[$attr] = trim($a[$attr].' '.$b[$attr], ' ');
					unset($a[$attr]);
				}
			}
		}

		return array_merge($a, $b);
	}
}
