/**
 * City Edit  Controller
 *
 * @param {object} $scope 	Angular $scope
 * @param {object} $filter  Angular Filter
 * @param {object} service to access city data via ajax.
 */
class CityEditCtrl  {

	constructor($scope, City, $routeParams, uiGmapGoogleMapApi ) {

		this._scope = $scope;

		this._resource = City.resource();

		this._wantedID = $routeParams.cityId;

		this._googleMap = uiGmapGoogleMapApi;

		this.init();

		this._scope.priority =  [

			{id: '1', name: 'Yüksek'},
			{id: '2', name: 'Normal'},
			{id: '3', name: 'Düşük'}
		];


	}

	show(cityId) {

		let city =  this._resource;

		return city.show( { id: cityId});
	}


	init() {

		let request  =  this.show(this._wantedID);

		request.$promise.then( (res) => {
			
			this._scope.city = res;

			this.mapInit(res);		
		});
	}
	
	/**
	 * Google Map
	 */
	mapInit(res) {
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
		 this._scope.options = {scrollwheel: true};

		/**
		 * Adds Location Markes on map
		 */
		 this._googleMap.then((maps) => {
		 
			 this._scope.marker = {

				 id: 0,
			     coords: {
					 
					 latitude	: res.latitude,
			         longitude	: res.longitude,
				 },
			 	
			 	options: { draggable: true },
			 };
			    
		});
	}
}

module.exports = CityEditCtrl;
