
/**
 * A resource to access current weather data restful services server-side
 *
 *  This resource class for only front-end !
 */
class Current {

	constructor($resource) {

		this._$resource = $resource;

		this._url = '/anlik/:id';
		
	}
	
	/**
	 * Restfull services
	 */
	resource() {

		let url = this._url;

		return this._$resource(url, {}, {
		
			'index' 	: { method: 'GET',  isArray:true, cache:true},
			'indexRandom' 	: { method: 'GET',  params: {mode:'rand', cnt: ':cnt'}, isArray:true, cache:true},
			
		});

	}
}

module.exports = Current; 
