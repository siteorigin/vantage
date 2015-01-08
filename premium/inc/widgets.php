<?php

/**
 * Add networks to the social media widget.
 *
 * @param $networks
 * @return array
 */
function vantage_premium_social_widget_add_networks($networks) {
	$networks = array_merge( $networks, array(
		// Add networks that have FontAwesome icons
		'linkedin' => __('LinkedIn', 'vantage'),
		'dribbble' => __('Dribbble', 'vantage'),
		'flickr' => __('Flickr', 'vantage'),
		'instagram' => __('Instagram', 'vantage'),
		'pinterest' => __('Pinterest', 'vantage'),
		'skype' => __('Skype', 'vantage'),
		'youtube' => __('YouTube', 'vantage'),
		'github' => __('GitHub', 'vantage'),
		'vimeo' => __('Vimeo', 'vantage'),
		'vk' => __('VK', 'vantage'),
	) );

	return $networks;
}
add_filter('vantage_social_widget_networks', 'vantage_premium_social_widget_add_networks');

/**
 * Add sizes to the social media widget.
 *
 * @param $sizes
 */
function vantage_premium_social_widget_add_sizes($sizes) {
	$sizes['small'] = __('Small', 'vantage');
	$sizes['large'] = __('Large', 'vantage');
	return $sizes;
}
add_filter('vantage_social_widget_sizes', 'vantage_premium_social_widget_add_sizes');

/**
 * Display the Vimeo icon
 * @return string
 */
function vantage_premium_social_widget_icon_vimeo(){
	return '<img src="'.get_template_directory_uri().'/premium/images/brands/vimeo.png" />';
}
add_filter('vantage_social_widget_icon_vimeo', 'vantage_premium_social_widget_icon_vimeo');