/**
 * A directive jQuery DataTables Plugins
 */
module.exports = () =>  {

	return {
		restrict: 'A',
		link: (scope, element, attrs) => {

			$(element).DataTable();
		}
	};
 };
