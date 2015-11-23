
/**
 * A resource to access city  restful services server-side
 */

class GoogleMap {

	constructor($window, $q) {

		this._defer = $q.defer();

		this._q		= $q;

		$window.googleInitMap = () => {

			this._defer.resolve();
		};

		this._dom = $window.document;

		/**
		 * Todo:
		 * Adds new mothods to configure google map api
		 */
		this._url = '//maps.googleapis.com/maps/api/js?callback=googleInitMap';
		this._iconBase = 'http://openweathermap.org/img/w/';
		this._map = {};

		this.mapInit();

	}

	/**
	 * Load Google Map Library by creating
	 * script element
	 */
	createScrElm() {

		let script = this._dom.createElement('script');

		script.src = this._url;

		this._dom.body.appendChild(script);

		return this._defer.promise;
	}

	/**
	 * Initial Google Map
	 */
	mapInit() {

		let includeMap = this.createScrElm();

		var defer = this._q.defer();	

		includeMap.then((res) => {;

			 let latlng = new google.maps.LatLng(39, 35);
			 
			 let elem = this._dom.getElementById('map_canvas'); 

			 var map =  new google.maps.Map(elem, {
				 
				 zoom 				: 6,
				 center				: latlng, 
				 scrollwheel 		: false,
			     disableDefaultUI 	: true,
				 mapTypeId: google.maps.MapTypeId.ROADMAP,			 
			 });

			defer.resolve(map);

		}, () => {

			defer.reject();		
		});

		this._map.$promise = defer.promise;	
	}

	/**
	 * To get initialized Map with $promise
	 */
	getMap() {

		return this._map;
	}

	/**
	 * Get URL for weather condition 
	 * icons file name
	 *
	 * @param {string} 
	 * @param {string}
	 */
	getIconUrl(icon) {

		let today 	= new Date();

		let hour 	= today.getHours();

		let url		= this._iconBase; 

		if (hour > 6 && hour < 20) {
			// day
			return url + icon + 'd.png';	   
		}
		// night
		return url + icon + 'n.png';
	}

	/**
	 * To create a icon for Google Map
	 */
	createWeatherIcon(icon) {

		 return  {

			  url: this.getIconUrl(icon),
			   // This marker is 20 pixels wide by 32 pixels high.
			  size: new google.maps.Size(50, 50),
			   // The origin for this image is (0, 0).
			  origin: new google.maps.Point(0, 0),
			   // The anchor for this image is the base of the flagpole at (0, 32).
			  anchor: new google.maps.Point(0, 32)				
		 };
	}

	/**
	 * To add markers to initialed map
	 */
	addMarkers(markers, map) {

		for (let  i = 0; i < markers.length; i++) {

			    var city = markers[i];

				var  marker = new google.maps.Marker({
								
				   		position: {

							lat: city.latitude,
					 		lng: city.longitude,
						},
					 	
						map: map,
					    icon: this.createWeatherIcon(city.icon),
						//shape: shape,
						title: city.title,
				});
		}
	}

}

module.exports = GoogleMap; 
