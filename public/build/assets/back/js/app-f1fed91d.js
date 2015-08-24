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

var myApp = angular.module('panelApp', ['ngRoute']);

/**
 * Services
 */

/**
 * Controllers
 */
myApp.controller('PanelCtrl', ['$scope', _appControllersPanelCtrlJs2['default']]);
//.controller('bookShelf.addBookController', AddBookController)
//.controller('bookShelf.archiveController', ArchiveController);;

/**
 * Setting Angular APP
 */
myApp.config(function ($interpolateProvider, $routeProvider) {

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
	}).otherwise({

		redirectTo: '/'
	});
});

},{"./app/controllers/panelCtrl.js":2}],2:[function(require,module,exports){
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

},{}]},{},[1]);
