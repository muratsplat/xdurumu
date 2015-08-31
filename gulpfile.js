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


/**
 * My Special Extentions
 */
require('./babelAngularExtention');


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

	/**
 	* Mergin all js scripts
 	*/
	mix.
		scripts(
		[	'libs/jQuery-2.1.4.min.js',
	 		'libs/bootstrap.min.js',
			'../../../bower_components/angular-route/angular-route.min.js',
			'../../../bower_components/angular-resource/angular-resource.min.js',
			'../../../bower_components/lodash/lodash.min.js',
			'../../../bower_components/angular-google-maps/dist/angular-google-maps.min.js',
			'libs/adminlte/app.min.js',
		

		], 
		'public/assets/back/js/libs/libs.js');
		
	   	/**
		 * ECMA Script 6-7
		 */	
		var backAngular = {

			src 	: './resources/assets/js/admin/app.js',
			dist	: './resources/assets/dist/back',
		};

		mix.angularPlusBabel({

				src : backAngular.src,
				dist: backAngular.dist,		
			});
		
		mix.copy(backAngular.dist + '/bundle.js', './public/assets/back/js');
		mix.copy(backAngular.dist + '/bundle.js.map',  './public/assets/back/js');	
	
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
	 * Vendor Paths
	 */
	var vendors = {

		js : {

			jSlimScroll : '../../../vendor/almasaeed2010/adminlte/plugins/slimScroll/jquery.slimscroll.min.js',
			fastClick	: '../../../vendor/almasaeed2010/adminlte/plugins/fastclick/fastclick.min.js',
			adminlte	: '../../../vendor/almasaeed2010/adminlte/dist/js/app.min.js'
		},

		css : {
			adminlte	: '../../../vendor/almasaeed2010/adminlte/dist/css/AdminLTE.min.css',
			skin_black	: '../../../vendor/almasaeed2010/adminlte/dist/css/skins/skin-black-light.min.css',
			skin_blue	: '../../../vendor/almasaeed2010/adminlte/dist/css/skins/skin-blue.min.css',
		}
	};

	/**
	 * Merged Some JS Plugins
	 */
	mix.scripts([

			vendors.js.jSlimScroll,
			vendors.js.fastClick,
			vendors.js.adminlte,
			],
			main.jsLibs
			);
	
	/**
	 * Sass For Main Domains
	 */
	mix.sass('front/main.scss', main.homePageCss);

	/**
	 * CSS files that is about only login page, register page
	 */	
	mix.styles([
			
			vendors.css.adminlte,
			vendors.css.skin_black,
			'front/homepage.css',
		],

		main.cssAll);


	/**
	 * hava.durumum.net
	 */
	var weather = {

		jsLibs		: 'public/assets/front/weather/js/libs.js',
		cssAll		: 'public/assets/front/weather/css/all.css',
		homePageCss : 'resources/assets/css/front/weather/homepage.css'
	};

	/**
	 * Merged Some JS Plugins
	 */
	mix.scripts([

				vendors.js.jSlimScroll,
				vendors.js.fastClick,
				vendors.js.adminlte
			],
			weather.jsLibs		
			);


	/**
	 * Sass For hava.durumu.net
	 */
	mix.sass('front/weather/main.scss', weather.homePageCss);


	/**
	 * CSS files that is about only login page, register page
	 */	
	mix.styles([
			
			vendors.css.adminlte,
			vendors.css.skin_blue,
			weather.homePageCss,
		],

			weather.cssAll
		);


	/*
	 |--------------------------
	 | hava.durumu.net
	 | Home Page AngularJS app
	 |--------------------------
	 */

	/**
 	* Mergin all js scripts
 	*/
	mix.
		scripts(
		[
			'../../../bower_components/angular-resource/angular-resource.min.js',
			'../../../bower_components/angular-route/angular-route.min.js',
			'../../../bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js',
		], 

		'public/assets/front/weather/js/home/libs.js');
		
		var weatherHomeAngular = {

			src 	: './resources/assets/js/front/weather/home/app.js',
			dist	: './resources/assets/dist/front/weather/home/dist',
		};

	  	/**
		 * ECMA Script 6-7
		 */	
		mix.angularPlusBabel({

				src : weatherHomeAngular.src,
				dist: weatherHomeAngular.dist,		
			});
		
		mix.copy(weatherHomeAngular.dist + '/bundle.js', './public/assets/front/weather/js/home');
		mix.copy(weatherHomeAngular.dist + '/bundle.js.map',  './public/assets/front/weather/js/home');

					   
	/**
 	* Cache Busting
	*/	
	mix.version([ 
		'assets/back/css/all.css',
	   	'assets/back/css/login/all.css',	
		'css/app.css', 
		'assets/back/js/bundle.js', 
		'assets/back/js/libs/libs.js',
		'assets/back/js/libs/login/libs.js',
		main.jsLibs,
		main.cssAll,
		weather.jsLibs,
		weather.cssAll,
		'assets/front/weather/js/home/libs.js',
		'assets/front/weather/js/home/bundle.js',
		]);
});

