
/**
 * A resource to access current weather data restful services server-side
 *
 *  This resource class for only front-end !
 */
class Current {

	constructor($resource, $location) {

		this._$resource = $resource;

		this._url = '/anlik/:id';

		this._$location = $location;		
	}
	
	/**
	 * Restfull services
	 */
	resource() {

		let url = this.getUrl();

		return this._$resource(url, {}, {
		
			'index' 	: { method: 'GET',  isArray:true, cache:true},
			'indexRandom' 	: { method: 'GET',  params: {mode:'rand', cnt: ':cnt'}, isArray:true, cache:true},
			
		});

	}

	/**
	 * To get url for $resource object
	 *
	 * return {string} 'http://api.foo.com/bar/:id'
	 */
	getUrl() {

		/**
		 * $location
		 * 	https://docs.angularjs.org/api/ng/service/$location
		 */
		let host 		= this.getHost();
		
		let port 		= this._$location.port();

		port  = port === 80 ? '' : ':' + port;

		let subdomain 	= 'api';

		let path 		= 'weather/current/:id';

		let url			= 'http://' + subdomain + '.' +  host + port + '/' + path;

		return url;
	}

	/**
	 * To get only main host name
	 *
	 * @return {string} 'foo.com'
	 */
	getHost() {

		let mixedHost = this._$location.host();

		var segments = mixedHost.split('.'); 
		var tmp = [];
		
		angular.forEach(segments, function(value, key) {
			
			if ( key >  0 ) {

				this.push(value);
			}

		}, tmp);
		
		return tmp.join('.');
	}


}

module.exports = Current; 
