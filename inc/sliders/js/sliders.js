jQuery( function ( $ ) {
	var $sliderMetabox = $( '#vantage-slider-page-slider' );
	var toggleSliderStretch = function ( selectedSlider ) {
		if ( selectedSlider && selectedSlider.search( /^(meta:)/ ) > -1 ) {
			$sliderMetabox.find( '.checkbox-wrapper' ).slideDown( 'fast' );
		} else {
			$sliderMetabox.find( '.checkbox-wrapper' ).slideUp( 'fast' );
		}
	};
	var $sliderDropdown = $sliderMetabox.find( 'select[name="vantage_page_slider"]' );
	$sliderDropdown.change( function() {
		toggleSliderStretch( $sliderDropdown.val() );
	} );
	toggleSliderStretch( $sliderDropdown.val() );
	
} );
