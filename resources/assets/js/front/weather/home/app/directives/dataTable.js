/**
 * A directive For Google Maps
 */
module.exports = () =>  {

	return {
		restrict: 'A',
		link: (scope, element, attrs) => {								
			
			console.log(element);				

		}
	};
 };

