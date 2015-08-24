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

/**
 * Admin LTE css files and images are coping...
 */
	
	/**
	 * CSS
	 */
	mix.copy('vendor/almasaeed2010/adminlte/dist/css', 'resources/assets/css/adminlte');
	mix.copy('vendor/almasaeed2010/adminlte/bootstrap', 'resources/assets/css/adminlte/bootstrap');
	mix.copy('vendor/almasaeed2010/adminlte/plugins', 'resources/assets/css/adminlte/plugins');

	/**
	 * Images
	 */
	mix.copy('vendor/almasaeed2010/adminlte/dist/img', 'public/assets/back/img');

	/**
	 * Coping Angular Templates
	 */
	mix.copy('resources/assets/js/admin/app/views', 'public/assets/back/app/views'); 

   
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

	/**
 	* Template's JS Files
 	*/	
	mix.copy('vendor/almasaeed2010/adminlte/plugins/jQuery/jQuery-2.1.4.min.js', 'resources/assets/js/libs');
	mix.copy('vendor/almasaeed2010/adminlte/bootstrap/js/bootstrap.min.js', 'resources/assets/js/libs');
	mix.copy('vendor/almasaeed2010/adminlte/dist/js/app.min.js', 'resources/assets/js/libs/adminlte');

/**
 * Mergin all js scripts
 */

	mix.
		scripts(
		[	'../../../bower_components/angular-route/angular-route.js',
			'../../../bower_components/angular-resource/angular-resource.js',
			'libs/jQuery-2.1.4.min.js',
	 		'libs/bootstrap.min.js',
			'libs/adminlte/app.min.js',
		

		], 
		'public/assets/back/js/libs/libs.js').
		
	  	/**
		 * ECMA Script 6-7
		 */
		//babel(['admin/*'], 'public/assets/back/js/app.js').
	
		browserify('admin/app.js', 'public/assets/back/js/app.js');

					   
/**
 * Cache Busting
 */
	
	mix.version([ 
		"assets/back/css/all.css", 
		'css/app.css', 
		'assets/back/js/app.js', 
		'assets/back/js/libs/libs.js']);
});
