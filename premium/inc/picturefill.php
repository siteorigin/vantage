<?php

/**
 * Add extras sizes for adaptive images
 */
function vantage_premium_mobile_image_setup(){
	if( siteorigin_setting('general_adaptive_images') ) {
		// Add image sizes for different versions
		add_image_size('vantage-thumbnail-mobile', 330, 174, true);
		add_image_size('vantage-thumbnail-no-sidebar-mobile', 330, 116, true);

		// Add all the relevant hooks
		add_filter('wp_get_attachment_image_attributes', 'vantage_premium_filter_thumbnail_attributes', 10, 5);
	}
}
add_action('after_setup_theme', 'vantage_premium_mobile_image_setup');

/**
 * Filter the thumbnail image to add srcset with different sizes
 */
function vantage_premium_filter_thumbnail_attributes( $attr, $attachment, $size ){
	if( $size == 'post-thumbnail' || $size == 'vantage-thumbnail-no-sidebar' ) {
		$srcset = array();

		// Add the mobile size for small screen devices
		$src = wp_get_attachment_image_src($attachment->ID, $size . '-mobile');
		if( !empty($src[0]) ) $srcset[480] = $src[0];

		// Add the normal size for small screen devices
		$src = wp_get_attachment_image_src($attachment->ID, $size );
		if( !empty($src[0]) ) $srcset[1080] = $src[0];

		$srcset = apply_filters('vantage_image_srcset', $srcset, $attr, $attachment, $size);

		if(!empty($srcset)) {
			$srcset_parts = array();
			foreach($srcset as $width => $image) {
				$srcset_parts[] = $image . ' ' . $width . 'w';
			}
			$attr['srcset'] = implode(', ', $srcset_parts);
		}
	}

	return $attr;
}