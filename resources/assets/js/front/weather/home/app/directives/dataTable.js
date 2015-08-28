/**
 * A directive jQuery DataTables Plugins
 */
module.exports = () =>  {

	return {
		restrict: 'A',
		link: (scope, element, attrs) => {								
			
			scope.cities.$promise.then(() => {
				/**
				 * DataTable plugins not working well now!
				 */
				//$(element).DataTable();	
			});
			
				

		}
	};
 };

