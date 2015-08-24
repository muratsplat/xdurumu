
/**
 * Angular 1.4.x App
 *
 * This file writes with ECMA Script 6-7
 */

import PanelCtrl 	from './app/controllers/panelCtrl.js';
import CityCtrl 	from './app/controllers/cityCtrl.js';
import dataTable	from './app/directives/dataTable.js';


let  myApp = angular.module('panelApp',['ngRoute']);

/**
 * Directives
 */
myApp.directive('jqDataTable', dataTable);


/**
 * Services
 */


/**
 * Controllers
 */
myApp.controller('PanelCtrl', ['$scope',  PanelCtrl])
  	.controller('CityCtrl',['$scope', CityCtrl]);
  	//.controller('bookShelf.archiveController', ArchiveController);;



/**
 * Setting Angular APP
 */
myApp.config( ($interpolateProvider, $routeProvider) =>  {

	/*
	 * Change  Angular default interpolote Symbol to avoid 
	 * Laravel blade interpolate symbol
	 */
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');

	/**
	 * Application Routing
	 */
	$routeProvider.

		when('/', {
			templateUrl: '/assets/back/app/views/panel.html',
			controller: PanelCtrl,
		})
		.when('/cities', {
			templateUrl: '/assets/back/app/views/cities.html',
			controller: CityCtrl,
		}).
		otherwise({

			redirectTo: '/'
		});
			  
});



