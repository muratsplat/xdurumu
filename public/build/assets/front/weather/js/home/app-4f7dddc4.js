(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){

/**
 * Angular 1.4.x App
 *
 * This file writes with ECMA Script 6-7
 */

'use strict';

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _appControllersHomeCtrlJs = require('./app/controllers/homeCtrl.js');

var _appControllersHomeCtrlJs2 = _interopRequireDefault(_appControllersHomeCtrlJs);

var _appResourcesCityJs = require('./app/resources/city.js');

//import Map			from './app/directives/openWeatherMap.js';
/**
 * create  Angular App Instance
 */

var _appResourcesCityJs2 = _interopRequireDefault(_appResourcesCityJs);

var myApp = angular.module('weatherHome', ['ngResource', 'ngRoute', 'uiGmapgoogle-maps']);

/**
 * Directives
 */
//myApp.directive('map', Map);

/**
 * Services*
 */
myApp.factory('City', ['$resource', function ($resource) {
	return new _appResourcesCityJs2['default']($resource);
}]);

/**
 * Controllers
 */
myApp.controller('HomeCtrl', ['$scope', 'uiGmapGoogleMapApi', 'City', _appControllersHomeCtrlJs2['default']]);
//  	.controller('CityCtrl',['$scope','$filter', 'City', 'ngNotify', CityCtrl])
//  	.controller('CityEditCtrl', ['$scope', 'City','$routeParams','uiGmapGoogleMapApi', 'ngNotify',  CityEditCtrl] );

/**
 * Setting Angular APP
 *
 * 
 */
myApp.config(function ($interpolateProvider, uiGmapGoogleMapApiProvider) {

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
		v: '3.17'
	});
});
//libraries: 'weather,geometry,visualization'

},{"./app/controllers/homeCtrl.js":2,"./app/resources/city.js":3}],2:[function(require,module,exports){
/**
 * Panel Controller
 */

'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var Home = (function () {
	function Home($scope, uiGmapGoogleMapApi, City) {
		_classCallCheck(this, Home);

		this._scope = $scope;

		this._scope.name = 'I am Panel Controller';

		this._map = uiGmapGoogleMapApi;

		this._city = City;

		this.mapInit();
	}

	/**
  * Google Map
  */

	_createClass(Home, [{
		key: 'mapInit',
		value: function mapInit(res) {
			var _this = this;

			/**
    * Example Response
    * {
    * 	id: "1327", 
    * 	name: "Karaçalı", 
    * 	country: "TR", 
    * 	latitude: "41.10810900", 
    * 	longitude: "30.31860900"
    * 	}
    */

			this._scope.map = {

				center: {

					latitude: 39, /*res.latitude, */
					longitude: 35 },

				/*res.longitude */
				zoom: 6
			};

			/**
    * Map Options
    */
			this._scope.options = { scrollwheel: true };

			/**
    * Adds Location Markes on map
    */
			this._map.then(function (maps) {

				console.log('map is loaded! ');
				_this._scope.marker = {

					id: 0,
					coords: {

						latitude: 38,
						longitude: 33
					},

					options: { draggable: true }
				};
			});
		}
	}]);

	return Home;
})();

module.exports = Home;

},{}],3:[function(require,module,exports){

/**
 * A resource to access city  restful services server-side
 */

'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var City = (function () {
	function City($resource) {
		_classCallCheck(this, City);

		this._$resource = $resource;

		this._url = '/back/city/:id';
	}

	/**
  * City Update Resonse Example
  * 
  * When if it is failed! 
  *
  *  http code: 500
  *  response: 	{"code":"500","msg":"City is not updated"} 
  *
  *  When it is successed!
  *
  *  http code: 204
  *  response: '' (empty string)
  *
 
 /**
  * To get index resource
  */

	_createClass(City, [{
		key: 'resource',
		value: function resource() {

			var url = this._url;

			return this._$resource(url, {}, {

				'index': { method: 'GET', isArray: true, cache: false },
				'show': { method: 'GET', isArray: false, cache: false },
				'update': { method: 'PUT', params: { id: '@id' }, isArray: false, cache: false }
			});
		}
	}]);

	return City;
})();

module.exports = City;

},{}]},{},[1]);
