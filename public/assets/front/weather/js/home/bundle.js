(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){

/**
 * Angular 1.4.x App
 *
 * This file writes with ECMA Script 6-7
 */

'use strict';

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _appControllersHomeCtrl = require('./app/controllers/homeCtrl');

var _appControllersHomeCtrl2 = _interopRequireDefault(_appControllersHomeCtrl);

var _appResourcesCity = require('./app/resources/city');

var _appResourcesCity2 = _interopRequireDefault(_appResourcesCity);

var _appResourcesCurrent = require('./app/resources/current');

var _appResourcesCurrent2 = _interopRequireDefault(_appResourcesCurrent);

//import GoMap		from './app/directives/googlaMap.js';

var _appFactoriesGoogleMap = require('./app/factories/googleMap');

var _appFactoriesGoogleMap2 = _interopRequireDefault(_appFactoriesGoogleMap);

/**
 * create  Angular App Instance
 */
var myApp = angular.module('weatherHome', ['ngResource', 'ngRoute', 'ngNotify']);

/**
 * Directives
 */
//myApp.directive('goMap', GoMap);

/**
 * Services
 */
myApp.factory('City', ['$resource', function ($resource) {
  return new _appResourcesCity2['default']($resource);
}]).factory('Current', ['$resource', function ($resource) {
  return new _appResourcesCurrent2['default']($resource);
}]).factory('goMapSrv', ['$window', '$q', function ($window, $q) {
  return new _appFactoriesGoogleMap2['default']($window, $q);
}]);

/**
 * Controllers
 */
myApp.controller('HomeCtrl', ['$scope', 'City', 'Current', 'ngNotify', 'goMapSrv', '$q', function ($scope, City, Current, ngNotify, goMapSrv, $q) {
  return new _appControllersHomeCtrl2['default']($scope, City, Current, ngNotify, goMapSrv, $q);
}]);
//  	.controller('CityCtrl',['$scope','$filter', 'City', 'ngNotify', CityCtrl])
//  	.controller('CityEditCtrl', ['$scope', 'City','$routeParams','uiGmapGoogleMapApi', 'ngNotify',  CityEditCtrl] );

/**
 * Setting Angular APP
 *
 * 
 */
myApp.config(function ($interpolateProvider) {

  /*
   * Change  Angular default interpolote Symbol to avoid 
   * Laravel blade interpolate symbol
   */
  $interpolateProvider.startSymbol('[[');
  $interpolateProvider.endSymbol(']]');
});

},{"./app/controllers/homeCtrl":3,"./app/factories/googleMap":4,"./app/resources/city":5,"./app/resources/current":6}],2:[function(require,module,exports){
/**
 * Base Controller
 *
 * @param {object} $scope 	Angular $scope
 */
'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var BaseCtrl = (function () {
	function BaseCtrl($scope, ngNotify) {
		_classCallCheck(this, BaseCtrl);

		this._scope = $scope;
		this._notify = ngNotify;
		this._scope.process = false;
	}

	/**
  * To send error notify
  */

	_createClass(BaseCtrl, [{
		key: 'sendErrorNotify',
		value: function sendErrorNotify(msg) {

			this._notify.set(msg, 'error');
		}

		/**
   * To send success notify
   */
	}, {
		key: 'sendSuccessNotify',
		value: function sendSuccessNotify(msg) {

			this._notify.set(msg, 'success');
		}

		/**
   * Show Procces
   *
   */
	}, {
		key: 'showProcess',
		value: function showProcess() {

			this._scope.process = true;
		}

		/**
   * Hide Procces
   */
	}, {
		key: 'hideProcess',
		value: function hideProcess() {

			this._scope.process = false;
		}
	}]);

	return BaseCtrl;
})();

module.exports = BaseCtrl;

},{}],3:[function(require,module,exports){
'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; desc = parent = getter = undefined; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _baseCtrlJs = require('./baseCtrl.js');

var _baseCtrlJs2 = _interopRequireDefault(_baseCtrlJs);

/**
 * Panel Controller
 */

var Home = (function (_Base) {
	_inherits(Home, _Base);

	function Home($scope, City, Current, ngNotify, goMapSrv, $q) {
		_classCallCheck(this, Home);

		_get(Object.getPrototypeOf(Home.prototype), 'constructor', this).call(this, $scope, ngNotify);

		this._scope = $scope;

		this._city = City;

		this._current = Current;

		this._map = goMapSrv;

		this._q = $q;

		this.showProcess();

		this.initMap();
	}

	/**
  * To get current resource
  *
  * Look at ../resources/current.js
  *
  */

	_createClass(Home, [{
		key: 'getCurrent',
		value: function getCurrent() {

			var request = this._current.resource();

			return request.indexRandom({ cnt: 150 });
		}

		/**
   * Create Map Markers
   */
	}, {
		key: 'createMarkers',
		value: function createMarkers() {

			this._scope.markers = [];

			var currents = this.getCurrent();

			var defer = this._q.defer();

			currents.$promise.then(function (res) {

				var markers = [];

				angular.forEach(res, function (v, k) {

					var marker = {

						latitude: Number(v.city.latitude),

						longitude: Number(v.city.longitude),

						title: v.city.name,

						icon: v.conditions[0].icon,

						options: {
							draggable: false
						}
					};

					markers.push(marker);
				});

				defer.resolve(markers);
			}, function (res) {

				defer.reject(res);
			});

			return defer.promise;
		}

		/**
   * Google Map
   */
	}, {
		key: 'initMap',
		value: function initMap() {
			var _this = this;

			var map = this._map.getMap();

			var markers = this.createMarkers();

			markers.then(function (items) {

				map.$promise.then(function (instanceMap) {

					_this._map.addMarkers(items, instanceMap);
				});

				_this.hideProcess();
			}, function (res) {

				console.error('Weather Currents can not reached !');
				console.error(res);
				_this.hideProcess();
			});
		}
	}]);

	return Home;
})(_baseCtrlJs2['default']);

module.exports = Home;

},{"./baseCtrl.js":2}],4:[function(require,module,exports){

/**
 * A resource to access city  restful services server-side
 */

'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var GoogleMap = (function () {
	function GoogleMap($window, $q) {
		var _this = this;

		_classCallCheck(this, GoogleMap);

		this._defer = $q.defer();

		this._q = $q;

		$window.googleInitMap = function () {

			_this._defer.resolve();
		};

		this._dom = $window.document;

		/**
   * Todo:
   * Adds new mothods to configure google map api
   */
		this._url = '//maps.googleapis.com/maps/api/js?key=AIzaSyDEOgcVkpgwi7TuYxZqqFultIURU20lyk8&callback=googleInitMap';
		this._iconBase = 'http://openweathermap.org/img/w/';
		this._map = {};

		this.mapInit();
	}

	/**
  * Load Google Map Library by creating
  * script element
  */

	_createClass(GoogleMap, [{
		key: 'createScrElm',
		value: function createScrElm() {

			var script = this._dom.createElement('script');

			script.src = this._url;

			this._dom.body.appendChild(script);

			return this._defer.promise;
		}

		/**
   * Initial Google Map
   */
	}, {
		key: 'mapInit',
		value: function mapInit() {
			var _this2 = this;

			var includeMap = this.createScrElm();

			var defer = this._q.defer();

			includeMap.then(function (res) {
				;

				var latlng = new google.maps.LatLng(39, 35);

				var elem = _this2._dom.getElementById('map_canvas');

				var map = new google.maps.Map(elem, {

					zoom: 6,
					center: latlng,
					scrollwheel: false,
					disableDefaultUI: true,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});

				defer.resolve(map);
			}, function () {

				defer.reject();
			});

			this._map.$promise = defer.promise;
		}

		/**
   * To get initialized Map with $promise
   */
	}, {
		key: 'getMap',
		value: function getMap() {

			return this._map;
		}

		/**
   * To create a icon for Google Map
   */
	}, {
		key: 'createWeatherIcon',
		value: function createWeatherIcon(icon) {

			return {

				url: this._iconBase + icon + '.png',
				// This marker is 20 pixels wide by 32 pixels high.
				size: new google.maps.Size(50, 50),
				// The origin for this image is (0, 0).
				origin: new google.maps.Point(0, 0),
				// The anchor for this image is the base of the flagpole at (0, 32).
				anchor: new google.maps.Point(0, 32)
			};
		}

		/**
   * To add markers to initialed map
   */
	}, {
		key: 'addMarkers',
		value: function addMarkers(markers, map) {

			for (var i = 0; i < markers.length; i++) {

				var city = markers[i];

				console.log(city);

				var marker = new google.maps.Marker({

					position: {

						lat: city.latitude,
						lng: city.longitude
					},

					map: map,
					icon: this.createWeatherIcon(city.icon),
					//shape: shape,
					title: city.title
				});
			}
		}
	}]);

	return GoogleMap;
})();

module.exports = GoogleMap;

},{}],5:[function(require,module,exports){

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

},{}],6:[function(require,module,exports){

/**
 * A resource to access current weather data restful services server-side
 *
 *  This resource class for only front-end !
 */
'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var Current = (function () {
	function Current($resource) {
		_classCallCheck(this, Current);

		this._$resource = $resource;

		this._url = '/anlik/:id';
	}

	/**
  * Restfull services
  */

	_createClass(Current, [{
		key: 'resource',
		value: function resource() {

			var url = this._url;

			return this._$resource(url, {}, {

				'index': { method: 'GET', isArray: true, cache: true },
				'indexRandom': { method: 'GET', params: { mode: 'rand', cnt: ':cnt' }, isArray: true, cache: true }

			});
		}
	}]);

	return Current;
})();

module.exports = Current;

},{}]},{},[1])


//# sourceMappingURL=bundle.js.map