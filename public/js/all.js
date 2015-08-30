
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

var _appResourcesCityJs2 = _interopRequireDefault(_appResourcesCityJs);

var _appResourcesCurrentJs = require('./app/resources/current.js');

//import GoMap		from './app/directives/googlaMap.js';

var _appResourcesCurrentJs2 = _interopRequireDefault(_appResourcesCurrentJs);

var _appFactoriesGoogleMapJs = require('./app/factories/googleMap.js');

/**
 * create  Angular App Instance
 */

var _appFactoriesGoogleMapJs2 = _interopRequireDefault(_appFactoriesGoogleMapJs);

var myApp = angular.module('weatherHome', ['ngResource', 'ngRoute', 'ngNotify']);

/**
 * Directives
 */
//myApp.directive('goMap', GoMap);

/**
 * Services
 */
myApp.factory('City', ['$resource', function ($resource) {
  return new _appResourcesCityJs2['default']($resource);
}]).factory('Current', ['$resource', function ($resource) {
  return new _appResourcesCurrentJs2['default']($resource);
}]).factory('goMapSrv', ['$window', '$q', function ($window, $q) {
  return new _appFactoriesGoogleMapJs2['default']($window, $q);
}]);

/**
 * Controllers
 */
myApp.controller('HomeCtrl', ['$scope', 'City', 'Current', 'ngNotify', 'goMapSrv', '$q', function ($scope, City, Current, ngNotify, goMapSrv, $q) {
  return new _appControllersHomeCtrlJs2['default']($scope, City, Current, ngNotify, goMapSrv, $q);
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
//# sourceMappingURL=all.js.map