/**
 * This File was created for city weather forcast view
 */



/**
 * Google Map 
 */

( (win, city) => {

	win.initMap = () => {

		let elem = document.getElementById('map_canvas');
		
		/**
		 * Position
		 */
		let  myLatLng = {
				lat: city.lat, 
				lng: city.lng 
		};

		/**
		 * create google map instance
		 */
		let map = new google.maps.Map(elem, {
	    	 	center: myLatLng,
	     		zoom: 7,
			 	disableDefaultUI: true,
				scrollwheel: false,
		});

		/**
		 * adds marker
		 */
		let  marker = new google.maps.Marker({
		      position: myLatLng,
		      map: map,
		      title: city.name,
			  draggable: false,
			  animation: google.maps.Animation.DROP,
		});

	};

})(window,city);                               
