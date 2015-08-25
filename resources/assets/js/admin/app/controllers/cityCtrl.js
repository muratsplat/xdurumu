/**
 * City Controller
 *
 * @param {object} $scope 	Angular $scope
 */
class CityCtrl  {

	constructor($scope, $filter, City) {

		this._$scope = $scope;

		this._$scope.name = 'I am Panel Controller';

		this._city = City;

		this.init();

		this._$scope.predicate = 'priority';
		this._$scope.reverse = true;
	}

	index() {

		let city =  this._city.resource();

		return city.index();
	}


	init() {

		let cities = this.index();

		let _scope = this._$scope;

		_scope.cities = cities;	

		/**
		 * Adding method to $scope
		 */
		_scope.order = (predicate) => {

			_scope.reverse = (_scope.predicate === predicate) 
				? !_scope.reverse 
				: false;
			_scope.predicate = predicate;
		};
	}




}

module.exports = CityCtrl;
