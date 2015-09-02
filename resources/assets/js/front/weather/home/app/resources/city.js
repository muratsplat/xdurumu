
/**
 * A resource to access city  restful services server-side
 */

class City {

	constructor($resource, $location) {

		this._$resource = $resource;	

		this._$location	= $location;
	}

	/**
	 * City Api Resful Services
	 */
	api() {

		let url = this.getUrl();

		return this._$resource(url, {}, {
		
			'index' 	: { method: 'GET',  isArray:true, cache:true},
			//'show'		: { method: 'GET',  isArray:false, cache: false},
			//'update'	: { method: 'PUT', params: {id:'@id'},  isArray: false, cache: false},  
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

		port  = port === 80 ? null : ':' + port;

		let subdomain 	= 'api';

		let path 		= 'city/:id';

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

module.exports = City; 
