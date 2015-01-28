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
