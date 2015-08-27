var elixir = require('laravel-elixir');
//var htmlmin = require('gulp-htmlmin');
//var gulp = require('gulp');


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
		//'adminlte/bootstrap/css/bootstrap.min.css',
		'../../../vendor/almasaeed2010/adminlte/dist/css/AdminLTE.min.css',
		'adminlte/fixes.css',
		'../../../vendor/almasaeed2010/adminlte/dist/css/skins/skin-blue.min.css',
		'../../../vendor/almasaeed2010/adminlte/plugins/morris/morris.css',
		'../../../vendor/almasaeed2010/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
		'adminlte/plugins/datepicker/datepicker3.css',
		'adminlte/plugins/daterangepicker/daterangepicker-bs3.css',
		'adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
		'adminlte/plugins/datatables/dataTables.bootstrap.css',

		],

		'public/assets/back/css');

	/**
	 * CSS files that is about only login page, register page
	 */	
	mix.styles(
		[
	
		'adminlte/AdminLTE.min.css',
		'adminlte/fixes.css',
		'adminlte/skins/skin-blue.min.css',
		],

		'public/assets/back/css/login');



	/**
 	* Template's JS Files
 	*/	
	mix.copy('vendor/almasaeed2010/adminlte/plugins/jQuery/jQuery-2.1.4.min.js', 'resources/assets/js/libs');
	mix.copy('vendor/almasaeed2010/adminlte/bootstrap/js/bootstrap.min.js', 'resources/assets/js/libs');
	mix.copy('vendor/almasaeed2010/adminlte/plugins/iCheck/icheck.min.js', 'resources/assets/js/libs');
	mix.copy('vendor/almasaeed2010/adminlte/dist/js/app.min.js', 'resources/assets/js/libs/adminlte');

//	mix.copy('vendor/almasaeed2010/adminlte/plugins/datatables/jquery.dataTables.min.js', 'resources/assets/js/libs');
//	mix.copy('vendor/almasaeed2010/adminlte/plugins/datatables/dataTables.bootstrap.min.js', 'resources/assets/js/libs');
//	mix.copy('vendor/almasaeed2010/adminlte/plugins/slimScroll/jquery.slimscroll.min.js', 'resources/assets/js/libs');
//	mix.copy('vendor/almasaeed2010/adminlte/plugins/fastclick/fastclick.min.js', 'resources/assets/js/libs');


	/**
 	* Mergin all js scripts
 	*/
	mix.
		scripts(
		[	'libs/jQuery-2.1.4.min.js',
	 		'libs/bootstrap.min.js',
			//'libs/jquery.dataTables.min.js',
			'../../../bower_components/angular-route/angular-route.js',
			'../../../bower_components/angular-resource/angular-resource.js',
			'../../../bower_components/lodash/lodash.min.js',
			'../../../bower_components/angular-google-maps/dist/angular-google-maps.min.js',
			'libs/adminlte/app.min.js',
		

		], 
		'public/assets/back/js/libs/libs.js');
		
	  	/**
		 * ECMA Script 6-7
		 */
		//babel(['admin/*'], 'public/assets/back/js/app.js').
	
		mix.browserify('admin/app.js', 'public/assets/back/js/app.js');
	
	/**
 	* Mergin all js scripts
 	*/
	mix.
		scripts(
		[	'libs/jQuery-2.1.4.min.js',
	 		'libs/bootstrap.min.js',
		],

		'public/assets/back/js/libs/login/libs.js');

	/*
	 * Front Template Assets are coping..
	 */
	mix.copy('vendor/almasaeed2010/adminlte/dist/css', 'public/assets/front/dist');;
	mix.copy('vendor/almasaeed2010/adminlte/plugins', 'public/assets/front/dist/plugins');
	
	/*	
 	|--------------------------------------------------------------------------
 	| Only Tasks for Front-End !!!
 	|--------------------------------------------------------------------------.
	|
 	*/

	/**
	 * durumum.net
	 */
	var main = { 

		jsLibs 		: 'public/assets/front/main/js/libs.js',
		cssAll 		: 'public/assets/front/main/css/all.css',
		homePageCss : 'resources/assets/css/front/homepage.css',
	};

	/**
	 * hava.durumum.net
	 */
	var weather = {

	};

	/**
	 * Merged Some JS Plugins
	 */
	mix.scripts([

			'../../../vendor/almasaeed2010/adminlte/plugins/slimScroll/jquery.slimscroll.min.js',
			'../../../vendor/almasaeed2010/adminlte/plugins/fastclick/fastclick.min.js',
			'../../../vendor/almasaeed2010/adminlte/dist/js/app.min.js'
			],
			main.jsLibs
			);

	
	/**
	 * Sass
	 */
	mix.sass('front/main.scss', main.homePageCss);

	/**
	 * CSS files that is about only login page, register page
	 */	
	mix.styles(
		[
	
		'../../../vendor/almasaeed2010/adminlte/dist/css/AdminLTE.min.css',
		'../../../vendor/almasaeed2010/adminlte/dist/css/skins/skin-black-light.min.css',
		'front/homepage.css',
		],

		main.cssAll);


					   
	/**
 	* Cache Busting
	*/	
	mix.version([ 
		'assets/back/css/all.css',
	   	'assets/back/css/login/all.css',	
		'css/app.css', 
		'assets/back/js/app.js', 
		'assets/back/js/libs/libs.js',
		'assets/back/js/libs/login/libs.js',
		main.jsLibs,
		main.cssAll,
		]);
});
