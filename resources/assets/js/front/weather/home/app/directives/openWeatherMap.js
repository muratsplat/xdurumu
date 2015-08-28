/**
 * A directive for https://github.com/buche/leaflet-openweathermap
 */
module.exports = () =>  {

	return {
		restrict: 'E',
		link: (scope, element, attrs) => {
			
			
			let mapContainer = document.createElement('div');

			mapContainer.id = 'map';
			
			element.append(mapContainer);

			/**
			 * Map Quest Initializing
			 */
			let mapquestUrl = "http://{s}.mqcdn.com/tiles/1.0.0/osm/{z}/{x}/{y}.png";
			let mapquestSubDomains = ["otile1","otile2","otile3","otile4"];
			let mapquestAttrib = 'Data, imagery and map information provided by '
								+ '<a href="http://open.mapquest.co.uk" target="_blank">MapQuest</a>, '
								+ '<a href="http://www.openstreetmap.org/" target="_blank">OpenStreetMap</a> and '
								+ '<a href="http://wiki.openstreetmap.org/wiki/Contributors" target="_blank">contributors</a>. '
								+ 'Data: <a href="http://wiki.openstreetmap.org/wiki/Open_Database_License" target="_blank">ODbL</a>, '
								+ 'Map: <a href="http://creativecommons.org/licenses/by-sa/2.0/" target="_blank">CC-BY-SA</a>';
			let mapquest = new L.TileLayer(mapquestUrl, {maxZoom: 18, attribution: mapquestAttrib, subdomains: mapquestSubDomains});
			
			let clouds = L.OWM.clouds({opacity: 0.8, legendImagePath: 'files/NT2.png'});
			let precipitation = L.OWM.precipitation( {opacity: 0.5} );
			let rain = L.OWM.rain({opacity: 0.5});
			let snow = L.OWM.snow({opacity: 0.5});
			let pressurecntr = L.OWM.pressureContour({opacity: 0.5});

			var markerFunc = (data) => {
	
				console.log(data);
	
				// just a Leaflet default marker
				return L.marker([data.coord.lat, data.coord.lon]);
				
			};



			let opts = {
				appId: '05c76be8d9fbf0c8fbe6f9a17ce4d356', 
				type: 'city', // available types: 'city', 'station'
				lang: 'en', // available: 'en', 'de', 'ru', 'fr', 'nl' (not every laguage is finished yet)
				minZoom: 7,
				intervall: 15, // intervall for rereading city/station data in minutes
				progressControl: false, // available: true, false
				imageLoadingUrl: null, // URL of loading image relative to HTML document
				temperatureUnit: 'C', // available: 'K' (Kelvin), 'C' (Celsius), 'F' (Fahrenheit)
				popup: false, // available: true, false
				keepPopup: true, // available: true, false
				showOwmStationLink: false, // available: true, false
				clusterSize: 150,
				imageUrlCity: 'http://openweathermap.org/img/w/{icon}.png',
				imageWidth: 50,
				imageHeight: 50,
				imageUrlStation: 'http://openweathermap.org/img/s/istation.png',
				imageUrlPlane: 'http://openweathermap.org/img/s/iplane.png',
				markerFunction: null, // user defined function for marker creation
				popupFunction: null, // user defined function for popup creation
				caching: true, // use caching of current weather data
				cacheMaxAge: 15, // maximum age of cache content in minutes before it gets invalidated
				keepOnMinZoom: false // keep or remove markers when zoom < minZoom	
			};

			var city = L.OWM.current(opts);


			var  map = L.map('map', { center: new L.LatLng(39, 35), zoom: 6, layers: [mapquest] });
			var overlayMaps = { "Clouds": clouds, "Cities": city };
			
			console.log(city);
