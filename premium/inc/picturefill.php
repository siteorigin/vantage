<?php

/**
 * Add extras sizes for adaptive images
 */
function vantage_premium_mobile_image_setup(){
	if( siteorigin_setting('general_adaptive_images') ) {
		// Add image sizes for different versions
		add_image_size('vantage-thumbnail-mobile', 330, 174, true);

		// Add all the relevant hooks
		add_action('wp_enqueue_scripts', 'vantage_premium_mobile_image_scripts', 10, 5);
		add_filter('wp_get_attachment_image_attributes', 'vantage_premium_filter_thumbnail_attributes', 10, 5);
	}
}
add_action('after_setup_theme', 'vantage_premium_mobile_image_setup');

/**
 * Enqueue the scripts that will handle the adaptive images
 */
function vantage_premium_mobile_image_scripts(){
	wp_enqueue_script('vantage-picturefill', get_template_directory_uri() . '/premium/js/picturefill.js', array(), SITEORIGIN_THEME_VERSION);
}

/**
 * Filter the thumbnail image to add srcset with different sizes
 */
function vantage_premium_filter_thumbnail_attributes( $attr, $attachment, $size ){
	if( $size == 'post-thumbnail' || $size == 'vantage-thumbnail-no-sidebar' ) {
		// Set mobile first, low res version.
		$src = wp_get_attachment_image_src($attachment->ID, 'vantage-thumbnail-mobile');
		if( !empty($src[0]) ) $attr['src'] = $src[0];

		// Go back to full size above 800px
		$srcset = array();
		$src = wp_get_attachment_image_src($attachment->ID, $size);
		if( !empty($src[0]) ) $srcset[] = $src[0] . ' 800w';
		$attr['srcset'] = implode(', ', $srcset);
	}

	return $attr;
}