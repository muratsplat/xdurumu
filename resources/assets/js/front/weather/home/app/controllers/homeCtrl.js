import Base 	from './baseCtrl.js';

/**
 * Panel Controller
 */

class Home extends Base {

	constructor($scope, City, Current, ngNotify, goMapSrv, $q) {

		super($scope, ngNotify);

		this._scope 	= $scope;

		this._city  	= City;

		this._current	= Current;

		this._map 		= goMapSrv;

		this._q			= $q;
		
		this.showProcess();

		this.initMap();
	}

	/**
	 * To get current resource
	 *
	 * Look at ../resources/current.js
	 *
	 */
	getCurrent() {
		
		let request  = this._current.resource();

		return request.indexRandom({cnt:150});
	}

	/**
	 * Create Map Markers
	 */
	createMarkers() {

		 this._scope.markers = [];

		 let currents 	= this.getCurrent();

		 var defer	 	= this._q.defer();

		 currents.$promise.then((res) => {

			var markers = [];

			angular.forEach(res, (v, k) => {
			
				let marker = {

					latitude : Number(v.city.latitude),

					longitude: Number(v.city.longitude),										

					title : v.city.name,

					icon  : v.conditions[0].icon,

					options : {
							draggable : false
					},
				};

				markers.push(marker);

			});	

			defer.resolve(markers);

		}, (res) =>  {

			defer.reject(res);		
		});

		return defer.promise;
	}

	/**
	 * Google Map
	 */
	initMap() {	

		let map = this._map.getMap();

		let markers = this.createMarkers();

		markers.then( (items) => {

			map.$promise.then( (instanceMap) => {	

				this._map.addMarkers(items, instanceMap);		
			});	

			this.hideProcess();	
				
		}, (res) =>  {

			console.error('Weather Currents can not reached !' );
		   	console.error(res);
			this.hideProcess();			
		});
				   
	}



}


module.exports = Home;
