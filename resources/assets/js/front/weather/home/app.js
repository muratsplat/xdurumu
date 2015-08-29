
/**
 * Angular 1.4.x App
 *
 * This file writes with ECMA Script 6-7
 */

import HomeCtrl		from './app/controllers/homeCtrl.js';
import City 		from './app/resources/city.js';
import Current		from './app/resources/current.js';
import GoMap		from './app/directives/googlaMap.js';
import GoMapSrv		from './app/factories/googleMap.js';
/**
 * create  Angular App Instance
 */
let  myApp = angular.module('weatherHome',['ngResource','ngRoute', 'ngNotify']);

/**
 * Directives
 */
myApp.directive('goMap', GoMap);


/**
 * Services*
 */
myApp
	.factory('City', ['$resource', ($resource) => new City($resource)])
	.factory('Current', ['$resource', ($resource) => new Current($resource)])
	.factory('goMapSrv', ['$window', '$q', ($window, $q) => new GoMapSrv($window, $q)]);


/**
 * Controllers
 */
myApp
	.controller('HomeCtrl', ['$scope','City','Current','ngNotify','goMapSrv', '$q', HomeCtrl]);
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



