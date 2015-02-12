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
 mix.less('app.less')
     .minify();
});

elixir(function(mix) {
 mix.scripts([
  "../../vendor/components/jquery/jquery.js",
  "../../vendor/twbs/bootstrap/js/affix.js",
  "../../vendor/twbs/bootstrap/js/alert.js",
  "../../vendor/twbs/bootstrap/js/button.js",
  "../../vendor/twbs/bootstrap/js/carousel.js",
  "../../vendor/twbs/bootstrap/js/collapse.js",
  "../../vendor/twbs/bootstrap/js/dropdown.js",
  "../../vendor/twbs/bootstrap/js/modal.js",
  "../../vendor/twbs/bootstrap/js/tooltip.js", // required by tooltip, so load it first
  "../../vendor/twbs/bootstrap/js/popover.js",
  "../../vendor/twbs/bootstrap/js/scrollspy.js",
  "../../vendor/twbs/bootstrap/js/tab.js",
  "../../vendor/twbs/bootstrap/js/transition.js",
  "app.js"
 ], 'public/js/plugins.js')
     .uglify();
});

