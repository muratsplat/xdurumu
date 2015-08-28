
/**
 * A resource to access city  restful services server-side
 */

class City {

	constructor($resource) {

		this._$resource = $resource;

		this._url = '/back/city/:id';
		
	}

	/**
	 * City Update Resonse Example
	 * 
	 * When if it is failed! 
	 *
	 *  http code: 500
	 *  response: 	{"code":"500","msg":"City is not updated"} 
	 *
	 *  When it is successed!
	 *
	 *  http code: 204
	 *  response: '' (empty string)
	 *
	
	/**
	 * To get index resource
	 */
	resource() {

		let url = this._url;

		return this._$resource(url, {}, {
		
			'index' 	: { method: 'GET',  isArray:true, cache:false},
			'show'		: { method: 'GET',  isArray:false, cache: false},
			'update'	: { method: 'PUT', params: {id:'@id'},  isArray: false, cache: false},  
		});

	}
}

module.exports = City; 
