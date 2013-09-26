<?php

/**
 * Setup all the premium settings.
 * 
 * @package vantage
 * @since vantage 1.0
 */
function vantage_premium_theme_settings(){
	// Implement all the teaser settings
	siteorigin_settings_add_field('logo', 'image_retina', 'media');

	siteorigin_settings_add_field('navigation', 'responsive_menu', 'checkbox');
	siteorigin_settings_add_field('navigation', 'responsive_menu_text', 'text');

	siteorigin_settings_add_field('navigation', 'responsive_menu_collapse', 'number', __('Mobile Menu Collapse', 'vantage'), array(
		'description' => __('The resolution when the menu collapses into a mobile navigation menu.', 'vantage')
	) );

	siteorigin_settings_add_field('social', 'ajax_comments', 'checkbox');
	siteorigin_settings_add_field('social', 'share_post', 'checkbox');
	siteorigin_settings_add_field('social', 'twitter', 'text', null, array(
		'validator' => 'twitter',
	));
}
add_action('admin_init', 'vantage_premium_theme_settings', 15);


function vantage_premium_theme_setting_defaults($defaults){
	$defaults['navigation_responsive_menu_collapse'] = 480;

	return $defaults;
}
add_filter('siteorigin_theme_default_settings', 'vantage_premium_theme_setting_defaults');