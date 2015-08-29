/**
 * Base Controller
 *
 * @param {object} $scope 	Angular $scope
 */
class BaseCtrl  {

	constructor( $scope, ngNotify ) {

		this._scope 		= $scope;
		this._notify  		= ngNotify;
		this._scope.process = false
	}

	/**
	 * To send error notify
	 */
	sendErrorNotify(msg) {

		this._notify.set(msg, 'error');
	}

	/**
	 * To send success notify
	 */
	sendSuccessNotify(msg) {

		this._notify.set(msg, 'success');
	}

	/**
	 * Show Procces
	 *
	 */
	showProcess() {

		this._scope.process = true;
	}

	/**
	 * Hide Procces
	 */
	hideProcess() {

		this._scope.process = false;
	}
	
}

module.exports = BaseCtrl;
