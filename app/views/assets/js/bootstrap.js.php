<?php 

$sFolder = base_path('vendor/twbs/bootstrap/js');
$aPlugins = array(
	// 'affix',
	// 'alert',
	// 'button',
	// 'carousel',
	'collapse',
	// 'dropdown',
	// 'modal',
	// 'tooltip', // popover requires tooltip, otherwise alphabetical load order works
	// 'popover',
	// 'scrollspy',
	// 'tab',
	// 'transition',
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
