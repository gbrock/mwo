var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

// Mix our single Less file
elixir(function(mix) {
	mix.less('app.less');
});

// Mix our JS scripts down to a single file
elixir(function(mix) {
	var mixScripts = [];
	var vendorFolder = '../../vendor/';
	var bootstrapPath = 'twbs/bootstrap/js/';
	var bootstrapModules = [
		'affix.js',
		'alert.js',
		'button.js',
		'carousel.js',
		'collapse.js',
		'dropdown.js',
		'modal.js',
		'tooltip.js',
		'popover.js',
		'scrollspy.js',
		'tab.js',
		'transition.js'
	];

	// add jquery
	mixScripts.push(vendorFolder + 'components/jquery/jquery.js');

	// add bootstrap modules
	for(var i = 0; i < bootstrapModules.length; i++)
	{
		mixScripts.push(vendorFolder + bootstrapPath + bootstrapModules[i]);
	}

	// add our app scripts
	mixScripts.push('app.js');

	// mix 'em together
	mix.scripts(plugins, 'public/js/plugins.js');
});

