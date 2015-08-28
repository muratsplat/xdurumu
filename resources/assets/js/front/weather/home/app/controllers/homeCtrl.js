/**
 * Panel Controller
 */

class Home {

	constructor($scope, uiGmapGoogleMapApi, City) {

		this._scope = $scope;

		this._scope.name = 'I am Panel Controller';

		this._map 	= uiGmapGoogleMapApi;

		this._city  = City;

		this.mapInit();



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

					latitude: 39,/*res.latitude, */
					longitude: 35, /*res.longitude */
				}, 

				zoom: 6, 
		 };

		/**
		 * Map Options
		 */
		 this._scope.options = {scrollwheel: true};

		/**
		 * Adds Location Markes on map
		 */
		 this._map.then((maps) => {

		 	console.log('map is loaded! ');
			 this._scope.marker = {

				 id: 0,
			     coords: {
					 
					 latitude	: 38,
			         longitude	: 33,
				 },
			 	
			 	options: { draggable: true },
			 };
			    
		});
	}



}


module.exports = Home;
