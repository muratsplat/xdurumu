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

			
		this._scope.incPriority = (event, city)  => {

			event.stopPropagation();

			this.incrementsPriority('inc', city);
		};

		this._scope.decrPriority= (event, city)  => {

			event.stopPropagation();

			this.incrementsPriority('decr', city);
		};
	}

	/**
	 * To increment City Priority
	 */
	incrementsPriority(type='inc', city) {

		let resource = this._city.resource();

		var  beforePriority = city.priority;

		if ('inc' === type) {

			city.priority--;

		} else {

			city.priority++;
		}

		let request = resource.update(city);

		request.$promise.then( (res) => {		

			this.sendSuccessNotify( city.name + ' başarıyla güncellendi.');
			
		}, (res) => {

			this.sendErrorNotify(city.name + ' güncellenirken bir hata oluştu!');
			
			city.priority = beforePriority;
			
			console.error(res);	
		});
	}

	/**
	 * To get all
	 */
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
