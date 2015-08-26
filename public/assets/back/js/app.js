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

//import dataTable	from './app/directives/dataTable.js';

var _appControllersCityEditCtrlJs2 = _interopRequireDefault(_appControllersCityEditCtrlJs);

var _appResourcesCityJs = require('./app/resources/city.js');

/**
 * create  Angular App Instance
 */

var _appResourcesCityJs2 = _interopRequireDefault(_appResourcesCityJs);

var myApp = angular.module('panelApp', ['ngRoute', 'ngResource', 'uiGmapgoogle-maps', 'ngNotify']);

/**
 * Directives
 */
//myApp.directive('jqDataTable', dataTable);

/**
 * Services*
 */
myApp.factory('City', ['$resource', function ($resource) {
	return new _appResourcesCityJs2['default']($resource);
}]);

/**
 * Controllers
 */
myApp.controller('PanelCtrl', ['$scope', _appControllersPanelCtrlJs2['default']]).controller('CityCtrl', ['$scope', '$filter', 'City', 'ngNotify', _appControllersCityCtrlJs2['default']]).controller('CityEditCtrl', ['$scope', 'City', '$routeParams', 'uiGmapGoogleMapApi', 'ngNotify', _appControllersCityEditCtrlJs2['default']]);

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

},{"./app/controllers/cityCtrl.js":3,"./app/controllers/cityEditCtrl.js":4,"./app/controllers/panelCtrl.js":5,"./app/resources/city.js":6}],2:[function(require,module,exports){
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

/**
 * City Controller
 *
 * @param {object} $scope 	Angular $scope
 */

var _baseCtrlJs2 = _interopRequireDefault(_baseCtrlJs);

var CityCtrl = (function (_Base) {
	_inherits(CityCtrl, _Base);

	function CityCtrl($scope, $filter, City, ngNotify) {
		var _this = this;

		_classCallCheck(this, CityCtrl);

		_get(Object.getPrototypeOf(CityCtrl.prototype), 'constructor', this).call(this, $scope, ngNotify);

		this._city = City;

		this.init();

		this._scope.predicate = 'priority';
		this._scope.reverse = true;

		this._scope.incPriority = function (event, city) {

			event.stopPropagation();

			_this.incrementsPriority('inc', city);
		};

		this._scope.decrPriority = function (event, city) {

			event.stopPropagation();

			_this.incrementsPriority('decr', city);
		};
	}

	/**
  * To increment City Priority
  */

	_createClass(CityCtrl, [{
		key: 'incrementsPriority',
		value: function incrementsPriority(type, city) {
			var _this2 = this;

			if (type === undefined) type = 'inc';

			var resource = this._city.resource();

			var beforePriority = city.priority;

			if ('inc' === type) {

				city.priority--;
			} else {

				city.priority++;
			}

			var request = resource.update(city);

			request.$promise.then(function (res) {

				_this2.sendSuccessNotify(city.name + ' başarıyla güncellendi.');
			}, function (res) {

				_this2.sendErrorNotify(city.name + ' güncellenirken bir hata oluştu!');

				city.priority = beforePriority;

				console.error(res);
			});
		}

		/**
   * To get all
   */
	}, {
		key: 'index',
		value: function index() {

			this.showProcess();

			var city = this._city.resource();

			return city.index();
		}
	}, {
		key: 'init',
		value: function init() {
			var _this3 = this;

			var cities = this.index();

			cities.$promise.then(function (res) {

				_scope.cities = res;

				_this3.hideProcess();
			});

			var _scope = this._scope;

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
})(_baseCtrlJs2['default']);

module.exports = CityCtrl;

},{"./baseCtrl.js":2}],4:[function(require,module,exports){
'use strict';

var _createClass = (function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ('value' in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; })();

var _get = function get(_x, _x2, _x3) { var _again = true; _function: while (_again) { var object = _x, property = _x2, receiver = _x3; desc = parent = getter = undefined; _again = false; if (object === null) object = Function.prototype; var desc = Object.getOwnPropertyDescriptor(object, property); if (desc === undefined) { var parent = Object.getPrototypeOf(object); if (parent === null) { return undefined; } else { _x = parent; _x2 = property; _x3 = receiver; _again = true; continue _function; } } else if ('value' in desc) { return desc.value; } else { var getter = desc.get; if (getter === undefined) { return undefined; } return getter.call(receiver); } } };

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { 'default': obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

function _inherits(subClass, superClass) { if (typeof superClass !== 'function' && superClass !== null) { throw new TypeError('Super expression must either be null or a function, not ' + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

var _baseCtrlJs = require('./baseCtrl.js');

/**
 * City Edit  Controller
 *
 * @param {object} $scope 	Angular $scope
 * @param {object} $filter  Angular Filter
 * @param {object} service to access city data via ajax.
 */

var _baseCtrlJs2 = _interopRequireDefault(_baseCtrlJs);

var CityEditCtrl = (function (_Base) {
	_inherits(CityEditCtrl, _Base);

	function CityEditCtrl($scope, City, $routeParams, uiGmapGoogleMapApi, ngNotify) {
		_classCallCheck(this, CityEditCtrl);

		_get(Object.getPrototypeOf(CityEditCtrl.prototype), 'constructor', this).call(this, $scope, ngNotify);

		this._resource = City.resource();

		this._wantedID = $routeParams.cityId;

		this._googleMap = uiGmapGoogleMapApi;

		this.init();

		this._scope.priority = [{ id: '1', name: 'Yüksek' }, { id: '2', name: 'Normal' }, { id: '3', name: 'Düşük' }];
	}

	/**
  * SHow City
  */

	_createClass(CityEditCtrl, [{
		key: 'showCity',
		value: function showCity() {
			var _this = this;

			this.showProcess();

			var city = this._resource;
			var id = this._wantedID;
			var request = city.show({ id: id });

			request.$promise.then(function (res) {

				_this._scope.city = res;

				_this.mapInit(res);

				_this.hideProcess();
			}, function (res) {

				_this.hideProcess();

				_this.sendErrorNotify('Sunucuya erişirken bir hata oldu! Sayfayı yenilemeyi deneyin.');
			});
		}

		/**
   * Update City
   *
   */
	}, {
		key: 'update',
		value: function update() {
			var _this2 = this;

			this.showProcess();

			var resource = this._resource;

			var city = this._scope.city;

			var request = resource.update(city);

			this.sendSuccessNotify('Your error message goes here!');

			/**
    * Success Response
    */
			var success = function success(res) {

				_this2.hideProcess();

				_this2.sendSuccessNotify(city.name + ' konum bilgisi başarıyla güncellendi.');
			};

			/**
    * Error Response
    */
			var error = function error(res) {

				_this2.hideProcess();

				var code = new String(res.status);

				var text = res.statusText;

				var srvMsg = JSON.stringify(res.data);

				var msg = '"' + city.name + '"' + ' konum bilgisi güncellenemedi. Hata Kodu: ' + code + ', Hata mesajı: ' + text + ', Sunucu cevabı: ' + srvMsg;

				_this2.sendErrorNotify(msg);
			};

			request.$promise.then(success, error);
		}

		/**
   * First jobs
   */
	}, {
		key: 'init',
		value: function init() {
			var _this3 = this;

			this.showCity();

			// adding city update methods for clicking
			this._scope.update = function () {

				_this3.update();
			};

			/*
    * If it is true, it shows overlay div 
    * for user
    */
			this._scope.proccess = false;
		}

		/**
   * Google Map
   */
	}, {
		key: 'mapInit',
		value: function mapInit(res) {
			var _this4 = this;

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

				_this4._scope.marker = {

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
})(_baseCtrlJs2['default']);

module.exports = CityEditCtrl;

},{"./baseCtrl.js":2}],5:[function(require,module,exports){
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
