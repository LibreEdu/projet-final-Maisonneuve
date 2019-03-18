( function( api ) {

	// Extends our custom "cocktail" section.
	api.sectionConstructor['cocktail'] = api.Section.extend( {

		// No cocktails for this type of section.
		attachCocktails: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );
