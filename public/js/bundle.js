(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){

/**
 * Angular 1.4.x App
 *
 * This file writes with ECMA Script 6-7
 */

'use strict';

var _appControllersPanelCtrlJs = require('./app/controllers/panelCtrl.js');

var myApp = angular.module('panelApp', []);

/**
 * Setting Angular APP
 */
myApp.config(function ($interpolateProvider, $routeProvider) {

	/*
  * Change  Angular default interpolote Symbol to avoid 
  * Laravel blade interpolate symbol
  */
	$interpolateProvider.startSymbol('<<');
	$interpolateProvider.endSymbol('>>');

	/**
  * Application Routing
  */
	$routeProvider.when('/login', {
		templateUrl: null,
		controller: null
	}).otherwise({

		redirectTo: '/'
	});
});

},{"./app/controllers/panelCtrl.js":2}],2:[function(require,module,exports){
/**
 * Panel Controller
 */

'use strict';

Object.defineProperty(exports, '__esModule', {
	value: true
});

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError('Cannot call a class as a function'); } }

var _default = function _default($scope) {
	_classCallCheck(this, _default);

	this._$scope = $scope;

	this._$scope = 'I am Panel Controller';
};

exports['default'] = _default;
module.exports = exports['default'];

},{}]},{},[1]);
