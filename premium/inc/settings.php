<?php

/**
 * Setup all the premium settings.
 * 
 * @package vantage
 * @since vantage 1.0
 */
function vantage_premium_theme_settings(){
	// Implement all the teaser settings
	siteorigin_settings_add_field('general', 'ajax_comments', 'checkbox');
	siteorigin_settings_add_field('layout', 'responsive_menu', 'checkbox');
}
add_action('admin_init', 'vantage_premium_theme_settings', 15);