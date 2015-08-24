/**
 * City Controller
 *
 * @param {object} $scope 	Angular $scope
 */
class CityCtrl  {

	constructor($scope) {

		this._$scope = $scope;

		this._$scope.name = 'I am Panel Controller';

	}

}

module.exports = CityCtrl;