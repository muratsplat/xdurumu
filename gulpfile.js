var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
});


/**
 * Admin LTE css files and images are coping...
 *
 * CSS
 */
elixir(function(mix) {
	mix.copy('vendor/almasaeed2010/adminlte/dist/css', 'resources/assets/css/adminlte');
	mix.copy('vendor/almasaeed2010/adminlte/bootstrap', 'resources/assets/css/adminlte/bootstrap');
	mix.copy('vendor/almasaeed2010/adminlte/plugins', 'resources/assets/css/adminlte/plugins');

	mix.copy('vendor/almasaeed2010/adminlte/dist/img', 'public/assets/back/img');
   
	/**
	 * Template's all css files are merging..
	 */	
	mix.styles(
		[
		'adminlte/bootstrap/css/bootstrap.min.css',
		'adminlte/AdminLTE.min.css',
		'adminlte/skins/skin-blue.min.css',
		'adminlte/plugins/iCheck/flat/blue.css',
		'adminlte/plugins/morris/morris.css',
		'adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
		'adminlte/plugins/datepicker/datepicker3.css',
		'adminlte/plugins/daterangepicker/daterangepicker-bs3.css',
		'adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',

				



		],

		'public/assets/back/css');
});

/**
 * Cache busting
 */
elixir(function(mix) {
	    
	mix.version('assets/back/css/all.css');
});

elixir(function(mix) {
	    
	mix.babel(['/admin/*'], 'public/js/back');
});


