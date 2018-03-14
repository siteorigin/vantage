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

function vantage_smartslider_affiliate( $source ) {
	return 'siteorigin';
}
add_filter( 'smartslider3_hoplink', 'vantage_smartslider_affiliate' );

if ( ! defined( 'METASLIDER_AFFILIATE_ID' ) ) {
	define( 'METASLIDER_AFFILIATE_ID', '3' );
}

function vantage_metaslider_affiliate_link_replace() {
	$url = add_query_arg( 'afref', METASLIDER_AFFILIATE_ID, 'https://www.metaslider.com/upgrade/' );
	return $url;
}
add_filter( 'metaslider_hoplink', 'vantage_metaslider_affiliate_link_replace' );

function vantage_metaslider_affiliate_banner_link_replace( $link ) {
	if ( strpos( $link, 'metaslider.com' ) ) {
		$link = add_query_arg( 'afref', METASLIDER_AFFILIATE_ID, $link );
	}
	return $link;
}
add_filter( 'updraftplus_com_link', 'vantage_metaslider_affiliate_banner_link_replace' );
