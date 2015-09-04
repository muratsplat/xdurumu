(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
/**
 * This File was created for city weather forcast view
 */

/**
 * Google Map 
 */

'use strict';

(function (win, city) {

	win.initMap = function () {

		var elem = document.getElementById('map_canvas');

		/**
   * Position
   */
		var myLatLng = {
			lat: city.lat,
			lng: city.lng
		};

		/**
   * create google map instance
   */
		var map = new google.maps.Map(elem, {
			center: myLatLng,
			zoom: 7,
			disableDefaultUI: true,
			scrollwheel: false
		});

		/**
   * adds marker
   */
		var marker = new google.maps.Marker({
			position: myLatLng,
			map: map,
			title: city.name,
			draggable: false,
			animation: google.maps.Animation.DROP
		});
	};
})(window, city);

},{}]},{},[1])


//# sourceMappingURL=bundle.js.map