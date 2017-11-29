<?php
/**
 * Integration with Smart Slider
 */

if ( ! function_exists( 'siteorigin_metaslider_get_options' ) ) :
function siteorigin_metaslider_get_options( $has_demo = true ) {
	$options = array( '' => __( 'None', 'vantage' ) );

	if ( $has_demo ) $options['demo'] = __( 'Demo Slider', 'vantage' );

	// Get metaslider sliders
	if ( class_exists( 'MetaSliderPlugin' ) ) {
		$ms_sliders = get_posts(array(
			'post_type' => 'ml-slider',
			'numberposts' => 200,
		) );

		foreach( $ms_sliders as $slider ) {
			$options[ 'meta:' . $slider->ID ] = __( 'Meta Slider: ', 'vantage' ) . $slider->post_title;
		}
	}

	// Get smart slider 3 sliders
	if ( class_exists( 'SmartSlider3' ) ) {
		global $wpdb;
		$ss_sliders = $wpdb->get_results( "SELECT id, title FROM " . $wpdb->prefix . "nextend2_smartslider3_sliders" );

		foreach( $ss_sliders as $slider ) {
			$options[ 'ss-meta:' . $slider->id ] = __( 'Smart Slider: ', 'vantage' ) . $slider->title;
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
	return 'affliate_identifier';
});
