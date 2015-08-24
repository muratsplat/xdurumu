
/**
 * Angular 1.4.x App
 *
 * This file writes with ECMA Script 6-7
 */

import PanelCtrl from './app/controllers/panelCtrl.js';



let  myApp = angular.module('panelApp',['ngRoute']);

/**
 * Services
 */




/**
 * Controllers
 */
myApp.controller('PanelCtrl', ['$scope',  PanelCtrl]);
  	//.controller('bookShelf.addBookController', AddBookController)
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
		}).
		otherwise({

			redirectTo: '/'
		});
			  
});



