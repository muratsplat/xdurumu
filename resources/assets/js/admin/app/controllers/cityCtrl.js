import Base  from './baseCtrl.js';


/**
 * City Controller
 *
 * @param {object} $scope 	Angular $scope
 */
class CityCtrl extends Base {

	constructor($scope, $filter, City, ngNotify) {

		super($scope, ngNotify);	

		this._city = City;

		this.init();

		this._scope.predicate = 'priority';
		this._scope.reverse = true;

		
		this._scope.incPriority = (event, cityId)  => {

			event.stopPropagation();

			console.log(cityId);
		};

		this._scope.decrPriority= (event, cityId)  => {

			event.stopPropagation();

			console.log(cityId);
		};
	}

	index() {

		this.showProcess();

		let city =  this._city.resource();

		return city.index();
	}


	init() {

		let cities = this.index();

		cities.$promise.then( (res) => {		
		
			_scope.cities = res;

			this.hideProcess();

		});

		let _scope = this._scope;

		/**
		 * Adding method to $scope
		 */
		_scope.order = (predicate) => {

			_scope.reverse = (_scope.predicate === predicate) 
				? !_scope.reverse 
				: false;
			_scope.predicate = predicate;
		}
	}	




}

module.exports = CityCtrl;
