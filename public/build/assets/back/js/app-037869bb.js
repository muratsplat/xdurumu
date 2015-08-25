(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){

/**
 * Angular 1.4.x App
 *
 * This file writes with ECMA Script 6-7
 */

'use strict';

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

var _appControllersPanelCtrlJs = require('./app/controllers/panelCtrl.js');

var _appControllersPanelCtrlJs2 = _interopRequireDefault(_appControllersPanelCtrlJs);

var _appControllersCityCtrlJs = require('./app/controllers/cityCtrl.js');

var _appControllersCityCtrlJs2 = _interopRequireDefault(_appControllersCityCtrlJs);

var _appControllersCityEditCtrlJs = require('./app/controllers/cityEditCtrl.js');

var _appControllersCityEditCtrlJs2 = _interopRequireDefault(_appControllersCityEditCtrlJs);

var _appDirectivesDataTableJs = require('./app/directives/dataTable.js');

var _appDirectivesDataTableJs2 = _interopRequireDefault(_appDirectivesDataTableJs);

var _appResourcesCityJs = require('./app/resources/city.js');

/**
 * create  Angular App Instance
 */

var _appResourcesCityJs2 = _interopRequireDefault(_appResourcesCityJs);

var myApp = angular.module('panelApp', ['ngRoute', 'ngResource', 'uiGmapgoogle-maps']);

/**
 * Directives
 */
myApp.directive('jqDataTable', _appDirectivesDataTableJs2['default']);

/**
 * Services*
 */
myApp.factory('City', ['$resource', function ($resource) {
	return new _appResourcesCityJs2['default']($resource);
}]);

/**
 * Controllers
 */
myApp.controller('PanelCtrl', ['$scope', _appControllersPanelCtrlJs2['default']]).controller('CityCtrl', ['$scope', '$filter', 'City', _appControllersCityCtrlJs2['default']]).controller('CityEditCtrl', ['$scope', 'City', '$routeParams', 'uiGmapGoogleMapApi', _appControllersCityEditCtrlJs2['default']]);

/**
 * Setting Angular APP
 *
 * Google MAP API Key : AIzaSyDEOgcVkpgwi7TuYxZqqFultIURU20lyk8
 */
myApp.config(function ($interpolateProvider, $routeProvider, uiGmapGoogleMapApiProvider) {

	/*
  * Change  Angular default interpolote Symbol to avoid 
  * Laravel blade interpolate symbol
  */
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');

	/**
  * Application Routing
  */
	$routeProvider.when('/', {
		templateUrl: '/assets/back/app/views/panel.html',
		controller: _appControllersPanelCtrlJs2['default']
	}).when('/cities', {

		templateUrl: '/assets/back/app/views/cities.html',
		controller: _appControllersCityCtrlJs2['default']
	}).when('/cities/:cityId', {

		templateUrl: '/assets/back/app/views/cityEdit.html',
		controller: _appControllersCityEditCtrlJs2['default']

	}).otherwise({

		redirectTo: '/cities'
	});

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

},{"./app/controllers/cityCtrl.js":2,"./app/controllers/cityEditCtrl.js":3,"./app/controllers/panelCtrl.js":4,"./app/directives/dataTable.js":5,"./app/resources/city.js":6}],2:[function(require,module,exports){
/**
 * City Controller
 *
 * @param {object} $scope 	Angular $scope
 */
'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var CityCtrl = (function () {
	function CityCtrl($scope, $filter, City) {
		_classCallCheck(this, CityCtrl);

		this._$scope = $scope;

		this._$scope.name = 'I am Panel Controller';

		this._city = City;

		this.init();

		this._$scope.predicate = 'priority';
		this._$scope.reverse = true;
	}

	_createClass(CityCtrl, [{
		key: 'index',
		value: function index() {

			var city = this._city.resource();

			return city.index();
		}
	}, {
		key: 'init',
		value: function init() {

			var cities = this.index();

			var _scope = this._$scope;

			_scope.cities = cities;

			/**
    * Adding method to $scope
    */
			_scope.order = function (predicate) {

				_scope.reverse = _scope.predicate === predicate ? !_scope.reverse : false;
				_scope.predicate = predicate;
			};
		}
	}]);

	return CityCtrl;
})();

module.exports = CityCtrl;

},{}],3:[function(require,module,exports){
/**
 * City Edit  Controller
 *
 * @param {object} $scope 	Angular $scope
 * @param {object} $filter  Angular Filter
 * @param {object} service to access city data via ajax.
 */
'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var CityEditCtrl = (function () {
	function CityEditCtrl($scope, City, $routeParams, uiGmapGoogleMapApi) {
		_classCallCheck(this, CityEditCtrl);

		this._scope = $scope;

		this._resource = City.resource();

		this._wantedID = $routeParams.cityId;

		this._googleMap = uiGmapGoogleMapApi;

		this.init();

		this._scope.priority = [{ id: '1', name: 'Yüksek' }, { id: '2', name: 'Normal' }, { id: '3', name: 'Düşük' }];
	}

	_createClass(CityEditCtrl, [{
		key: 'show',
		value: function show(cityId) {

			var city = this._resource;

			return city.show({ id: cityId });
		}
	}, {
		key: 'init',
		value: function init() {
			var _this = this;

			var request = this.show(this._wantedID);

			request.$promise.then(function (res) {

				_this._scope.city = res;

				_this.mapInit(res);
			});
		}

		/**
   * Google Map
   */
	}, {
		key: 'mapInit',
		value: function mapInit(res) {
			var _this2 = this;

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

					latitude: res.latitude,
					longitude: res.longitude
				},

				zoom: 9
			};

			/**
    * Map Options
    */
			this._scope.options = { scrollwheel: true };

			/**
    * Adds Location Markes on map
    */
			this._googleMap.then(function (maps) {

				_this2._scope.marker = {

					id: 0,
					coords: {

						latitude: res.latitude,
						longitude: res.longitude
					},

					options: { draggable: true }
				};
			});
		}
	}]);

	return CityEditCtrl;
})();

module.exports = CityEditCtrl;

},{}],4:[function(require,module,exports){
/**
 * Panel Controller
 */

'use strict';

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var PanelCtrl = function PanelCtrl($scope) {
	_classCallCheck(this, PanelCtrl);

	this._$scope = $scope;

	this._$scope.name = 'I am Panel Controller';
};

module.exports = PanelCtrl;

},{}],5:[function(require,module,exports){
/**
 * A directive jQuery DataTables Plugins
 */
'use strict';

module.exports = function () {

	return {
		restrict: 'A',
		link: function link(scope, element, attrs) {

			scope.cities.$promise.then(function () {
				/**
     * DataTable plugins not working well now!
     */
				//$(element).DataTable();	
			});
		}
	};
};

},{}],6:[function(require,module,exports){

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
  * To get index resource
  */

	_createClass(City, [{
		key: 'resource',
		value: function resource() {

			var url = this._url;

			return this._$resource(url, {}, {

				'index': { method: 'GET', params: {}, isArray: true, cache: false },
				'show': { method: 'GET', params: {}, isArray: false, cache: false }
			});
		}
	}]);

	return City;
})();

module.exports = City;

},{}]},{},[1]);
