
/**
 * A resource to access city  restful services server-side
 */

class City {

	constructor($resource) {

		this._$resource = $resource;

		this._url = '/back/city/:id';
		
	}
	
	/**
	 * To get index resource
	 */
	resource() {

		let url = this._url;

		return this._$resource(url, {}, {
		
			'index' : { method: 'GET', params:{}, isArray:true, cache:false},
			'show'	: { method: 'GET', params:{}, isArray:false, cache: false},
		});

	}
}

module.exports = City; 
