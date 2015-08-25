
/**
 * Angular 1.4.x App
 *
 * This file writes with ECMA Script 6-7
 */

import PanelCtrl 	from './app/controllers/panelCtrl.js';
import CityCtrl 	from './app/controllers/cityCtrl.js';
import CityEditCtrl	from './app/controllers/cityEditCtrl.js';
import dataTable	from './app/directives/dataTable.js';
import City			from './app/resources/city.js';

/**
 * create  Angular App Instance
 */
let  myApp = angular.module('panelApp',['ngRoute', 'ngResource']);

/**
 * Directives
 */
myApp.directive('jqDataTable', dataTable);


/**
 * Services*
 */
myApp.factory('City', ['$resource', ($resource) => new City($resource)]);


/**
 * Controllers
 */
myApp
	.controller('PanelCtrl', ['$scope',  PanelCtrl])
  	.controller('CityCtrl',['$scope','$filter', 'City', CityCtrl])
  	.controller('CityEditCtrl', ['$scope', 'City','$routeParams', CityEditCtrl] );

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
		})
		.when('/cities/:cityId', {
			
			templateUrl: '/assets/back/app/views/cityEdit.html',
			controller: CityEditCtrl,
					
		}).
		otherwise({

			redirectTo: '/'
		});
			  
});



