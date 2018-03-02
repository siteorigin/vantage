<?php
/**
 * Integration with Smart Slider
 */

if ( ! function_exists( 'siteorigin_smartslider_get_options' ) ) :
function siteorigin_smartslider_get_options() {
	$options = array( '' => __( 'None', 'vantage' ) );

	// Get smart slider 3 sliders
	if ( class_exists( 'SmartSlider3' ) ) {
		global $wpdb;
		$sliders = $wpdb->get_results( "SELECT id, title FROM " . $wpdb->prefix . "nextend2_smartslider3_sliders" );

		foreach( $sliders as $slider ) {
			$options[ 'meta:' . $slider->id ] = __( 'Slider: ', 'vantage' ) . $slider->title;
		}
	}

	return $options;
}
endif;

if ( ! function_exists( 'siteorigin_smartslider_install_link' ) ) :
function siteorigin_smartslider_install_link(){
	if ( function_exists( 'siteorigin_plugin_activation_install_url' ) ) {
		return siteorigin_plugin_activation_install_url( 'smart-slider-3', 'SmartSlider' );
	}
	else {
		return 'http://downloads.wordpress.org/plugin/smart-slider-3.zip';
	}
}
endif;

add_filter( 'smartslider3_hoplink', function( $source ){
	return 'siteorigin';
});
