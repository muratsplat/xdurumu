import Base 	from './baseCtrl.js';

/**
 * Panel Controller
 */
class HomeCtrl extends Base {

	constructor($scope, City, Current, ngNotify, goMapSrv, $q, $location, $window) {

		super($scope, ngNotify);

		this._scope 	= $scope;

		this._location	= $location;

		this._window	= $window;

		this._cities	= [];

		/**
		 * ui-boostrap typeahead
		 */
		this._scope.search = {

			selected: undefined,
			cities	: [],
		};

		this._city  	= City;

		this._current	= Current;

		this._map 		= goMapSrv;

		this._q			= $q;
		
		this.showProcess();

		this.initMap();

		this.init();
	}

	/**
	 * For initial jobs
	 */
	init() {

		var search = this._scope.search;


		this._scope.callCities = () => {

			if ( this._cities.length > 0 ) {

				search.cities = this._cities;

				return;
			}
		
			this.getCities();

			search.cities = this._cities;
		};

		this._scope.iconSuffix = this.nightOrDay();
		
		/**
		 * Weather Conditions Counts
		 */
		this._scope.conditions = [];
		
		/**
		 * Weather Condition Counter Method
		 */
		this._scope.conditionCounter = (elem) => {

			return this._scope.conditions.filter((e) => {

				return elem === e;		
			
			}).length;		
		};
		
		/**
		 * Determine if passed value is in cities array
		 * 
		 * @return bool
		 */
		this._scope.inCities = () => {			

			return search.cities.filter((e) => {

				return search.selected === e.name;		

			}).length > 0;	
		};


		this._scope.findCity = () => {

			if ( this._scope.inCities() ) {

				this._window.location = '/konum/' . search.selected;
				
				return;
			}

			console.log('şehir geçersiz');
		
		};
	}


	/**
	 * To return day or night code
	 *
	 * @return {string}
	 */
	nightOrDay() {
	
		let today 	= new Date();

		let hour 	= today.getHours();

		let url		= this._iconBase; 

		if (hour > 6 && hour < 20) {
			// day
			return 'd';	   
		}
		// night
		return 'n';
	}


	/**
	 * To get all cities
	 *
	 */
	getCities() {

		let request = this._city.api().index();
			
		/**
		 * When failed response, it will called!
		 */	
		let failed  = (res) => {
	
			console.error('Cit List not reached !');

			this.sendErrorNotify('Konumlara erişilemedi ! Sayfayı yenilemeyi deneyin..');
		};

		/**
		 * When response is successed, 
		 * it will called!
		 */	
		let success  = (res) => {
	
			this._cities = res;
		};

		request.$promise.then(success, failed);
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

				this._scope.conditions.push(v.conditions[0].icon);
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


module.exports = HomeCtrl;
