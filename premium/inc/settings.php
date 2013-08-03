<?php

/**
 * Setup all the premium settings.
 * 
 * @package sostarter
 * @since sostarter 1.0
 */
function sostarter_premium_theme_settings(){
	// Implement all the teaser settings
	siteorigin_settings_add_field('general', 'ajax_comments', 'checkbox');
	siteorigin_settings_add_field('layout', 'responsive_menu', 'checkbox');
}
add_action('admin_init', 'sostarter_premium_theme_settings', 15);