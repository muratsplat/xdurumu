
/**
 * Angular 1.4.x App
 *
 * This file writes with ECMA Script 6-7
 */

import HomeCtrl		from './app/controllers/homeCtrl.js';
import City 		from './app/resources/city.js';
//import Map			from './app/directives/openWeatherMap.js';
/**
 * create  Angular App Instance
 */
let  myApp = angular.module('weatherHome',['ngResource','ngRoute', 'uiGmapgoogle-maps']);

/**
 * Directives
 */
//myApp.directive('map', Map);


/**
 * Services*
 */
myApp.factory('City', ['$resource', ($resource) => new City($resource)]);


/**
 * Controllers
 */
myApp
	.controller('HomeCtrl', ['$scope', 'uiGmapGoogleMapApi','City',  HomeCtrl]);
//  	.controller('CityCtrl',['$scope','$filter', 'City', 'ngNotify', CityCtrl])
//  	.controller('CityEditCtrl', ['$scope', 'City','$routeParams','uiGmapGoogleMapApi', 'ngNotify',  CityEditCtrl] );

/**
 * Setting Angular APP
 *
 * 
 */
myApp.config( ($interpolateProvider, uiGmapGoogleMapApiProvider ) =>  {

	/*
	 * Change  Angular default interpolote Symbol to avoid 
	 * Laravel blade interpolate symbol
	 */
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');

	
	/**
	 * Google MAP Angular Plugins Configurations
	 * Look at: http://angular-ui.github.io/angular-google-maps/#!/api/GoogleMapApi
	 */
	  uiGmapGoogleMapApiProvider.configure({
		    
		 key: 'AIzaSyDEOgcVkpgwi7TuYxZqqFultIURU20lyk8',
		 v: '3.17',
	 	 //libraries: 'weather,geometry,visualization'
	 });
	 

});



