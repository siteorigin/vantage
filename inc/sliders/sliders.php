<?php
/**
 * Integration with sliders.
 */

if ( ! function_exists( 'vantage_sliders_get_options' ) ) :
function vantage_sliders_get_options( $has_demo = true ) {
	$options = array( '' => __( 'None', 'vantage' ) );

	if ( $has_demo ) $options['demo'] = __( 'Demo Slider', 'vantage' );
	
	if ( class_exists( 'MetaSliderPlugin' ) ) {
		$sliders = get_posts(array(
			'post_type' => 'ml-slider',
			'numberposts' => 200,
		) );

		foreach ( $sliders as $slider ) {
			$options[ 'meta:' . $slider->ID ] = __( 'MetaSlider: ', 'vantage' ) . $slider->post_title;
		}
	}
	
	if ( class_exists( 'SmartSlider3' ) ) {
		global $wpdb;
		$sliders = $wpdb->get_results( "SELECT id, title FROM " . $wpdb->prefix . "nextend2_smartslider3_sliders LIMIT 200" );
		
		foreach( $sliders as $slider ) {
			$options[ 'smart:' . $slider->id ] = __( 'Smart Slider: ', 'vantage' ) . $slider->title;
		}
	}

	return $options;
}
endif;

if ( ! function_exists( 'vantage_smartslider_install_link' ) ) :
	function vantage_smartslider_install_link() {
		if ( function_exists( 'siteorigin_plugin_activation_install_url' ) ) {
			return siteorigin_plugin_activation_install_url( 'smart-slider-3', 'SmartSlider' );
		} else {
			return 'http://downloads.wordpress.org/plugin/smart-slider-3.zip';
		}
	}
endif;
