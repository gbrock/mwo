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

elixir(function(mix) {
 mix.less('app.less');
});

elixir(function(mix) {
 var plugins = [];
 var vendorFolder = '../../vendor/';
 var bsPath = 'twbs/bootstrap/js/';
 var bsPlugins = [
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
 plugins.push(vendorFolder + 'components/jquery/jquery.js');

 // add bootstrap plugins
 for(var i = 0; i < bsPlugins.length; i++)
 {
  plugins.push(vendorFolder + bsPath + bsPlugins[i]);
 }

 // add our app scripts
 plugins.push('app.js');

 // mix 'em together
 mix.scripts(plugins, 'public/js/plugins.js');
});

