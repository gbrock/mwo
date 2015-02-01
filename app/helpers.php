<?php

/**
 * output whatever variable is passed on-screen for debugging purposes
 * 
 * @param mixed $oVar the variable to be debugged
 * @param bool $bContinue if false, sends a full-stop to the running script
 * @return void
 *
 * @author gBrock
 * @license http://creativecommons.org/publicdomain/zero/1.0/ Public Domain
 */
if(!function_exists('dd'))
{
	function dd($oVar = NULL, $bContinue = FALSE)
	{
		echo '<pre>';
		switch(TRUE)
		{
			case $oVar === FALSE:
				echo 'FALSE (bool)'; // Boolean, FALSE
				break;
			case $oVar === TRUE:
				echo 'TRUE (bool)'; // Boolean, TRUE
				break;
			case $oVar === NULL:
				echo 'NULL (empty)'; // NULL value
				break;
			case is_string($oVar) && $oVar === '':
				echo '""'; // empty string
				break;
			case is_string($oVar):
				echo $oVar; // a regular string
				break;
			default:
				print_r($oVar); // anything else
				break;
		}
		echo '</pre>';

		if(!$bContinue)
		{
			// Set the header so output looks correct in-browser
			// header('Content-Type: text/html; charset=UTF-8');
			exit;
		}
	}
}

if(!function_exists('pairify'))
{
	/**
	 * Make a simple key-value pair based on an array of objects, usually
	 * database records.
	 * @param  array $oVar  The array of objects
	 * @param  string $key   Which object key should be used as the new Key
	 * @param  string $value Which object key should be used as the new Value
	 * @return array        The simplified array
	 */
	function pairify($oVar, $key, $value)
	{
		/**
		 * The return array.
		 * @var array
		 */
		$r = array();

		if(!is_array($oVar))
		{
			throw new Exception('pairify() requires an array of objects.');
		}

		if(!is_string($key) || !is_string($value))
		{
			throw new Exception('pairify() requires strings to set as "key" and "value".');
		}

		// If the set isn't empty
		if(count($oVar) > 0)
		{
			foreach($oVar as $record)
			{
				$record_k = isset($record->{$key}) ? strval($record->{$key}) : NULL;
				$record_v = isset($record->{$value}) ? $record->{$value} : NULL;

				if($record_k)
				{
					$r[$record_k] = $record_v;
				}
			}
		}

		return $r;
	}
}
