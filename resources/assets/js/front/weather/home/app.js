
/**
 * Angular 1.4.x App
 *
 * This file writes with ECMA Script 6-7
 */

import HomeCtrl		from './app/controllers/homeCtrl';
import City 		from './app/resources/city';
import Current		from './app/resources/current';
//import GoMap		from './app/directives/googlaMap.js';
import GoMapSrv		from './app/factories/googleMap';
/**
 * create  Angular App Instance
 */
let  myApp = angular.module('weatherHome',['ngResource','ngRoute', 'ngNotify', 'ui.bootstrap']);

/**
 * Directives
 */
//myApp.directive('goMap', GoMap);


/**
 * Services
 */
myApp
	.factory('City', 
			['$resource', '$location', 
			($resource, $location) => 
			new City($resource, $location)])
	.factory('Current', ['$resource', ($resource) => new Current($resource)])
	.factory('goMapSrv', ['$window', '$q', ($window, $q) => new GoMapSrv($window, $q)]);


/**
 * Controllers
 */
myApp
	.controller('HomeCtrl', [

			'$scope','City','Current','ngNotify','goMapSrv', '$q',
			
			($scope,City,Current,ngNotify,goMapSrv, $q ) => new HomeCtrl($scope,City,Current,ngNotify,goMapSrv, $q)
			
			]);
//  	.controller('CityCtrl',['$scope','$filter', 'City', 'ngNotify', CityCtrl])
//  	.controller('CityEditCtrl', ['$scope', 'City','$routeParams','uiGmapGoogleMapApi', 'ngNotify',  CityEditCtrl] );

/**
 * Setting Angular APP
 *
 * 
 */
myApp.config( ($interpolateProvider ) =>  {

	/*
	 * Change  Angular default interpolote Symbol to avoid 
	 * Laravel blade interpolate symbol
	 */
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');

	 

});



