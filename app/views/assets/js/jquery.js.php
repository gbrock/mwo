<?php 

$sFolder = base_path('components/jquery');
$aPlugins = array(
	'jquery',
);

if(count($aPlugins))
{
	foreach($aPlugins as $plug)
	{
		$sFile = $sFolder . '/' . $plug . '.js';
		if(file_exists($sFile))
		{
			echo file_get_contents($sFile);
		}
	}
}
