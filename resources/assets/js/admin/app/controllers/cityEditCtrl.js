import Base  from './baseCtrl.js';

/**
 * City Edit  Controller
 *
 * @param {object} $scope 	Angular $scope
 * @param {object} $filter  Angular Filter
 * @param {object} service to access city data via ajax.
 */
class CityEditCtrl extends Base {

	constructor($scope, City, $routeParams, uiGmapGoogleMapApi, ngNotify ) {

		super($scope, ngNotify);

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

	/**
	 * SHow City
	 */
	showCity() {

		this.showProcess();

		let city 	= this._resource;
		let id 		= this._wantedID; 
		let request =city.show( { id: id});

		request.$promise.then( (res) => {
			
			this._scope.city = res;

			this.mapInit(res);

			this.hideProcess();
		
		},(res) => {

			this.hideProcess();

			this.sendErrorNotify('Sunucuya erişirken bir hata oldu! Sayfayı yenilemeyi deneyin.');		
		});
	}

	/**
	 * Update City
	 *
	 */
	update() {

		this.showProcess();

		let resource = this._resource;

		let city = this._scope.city;

		let request = resource.update(city);

		this.sendSuccessNotify('Your error message goes here!');
		
		/**
		 * Success Response
		 */	
		let success =  (res) => {

			this.hideProcess();

			this.sendSuccessNotify( city.name +  ' konum bilgisi başarıyla güncellendi.')	
		};

		/**
		 * Error Response
		 */
		let error = (res) => {

			this.hideProcess();

			let code	= new String(res.status);

			let text 	= res.statusText;

			let srvMsg	= JSON.stringify(res.data);

			let msg =  '"' + city.name + '"' + ' konum bilgisi güncellenemedi. Hata Kodu: ' + code + ', Hata mesajı: ' + text + ', Sunucu cevabı: ' + srvMsg  ; 

			this.sendErrorNotify( msg );
		};

		request.$promise.then( success, error );	
	}	

	/**
	 * First jobs
	 */
	init() {

		this.showCity();

			// adding city update methods for clicking
		this._scope.update = () => {

			this.update();		
		};

		/*
		 * If it is true, it shows overlay div 
		 * for user
		 */
		this._scope.proccess = false;
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
