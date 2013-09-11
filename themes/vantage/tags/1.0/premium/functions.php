<?php

define('SITEORIGIN_IS_PREMIUM', true);

// Include all the premium extras
include get_template_directory() . '/premium/extras/ajax-comments/ajax-comments.php';
include get_template_directory() . '/premium/extras/mobilenav/mobilenav.php';
include get_template_directory() . '/premium/extras/css/css.php';
include get_template_directory() . '/premium/extras/customizer/customizer.php';
include get_template_directory() . '/premium/extras/share/share.php';

// Theme specific files
include get_template_directory() . '/premium/inc/settings.php';
include get_template_directory() . '/premium/inc/customizer.php';

function vantage_premium_setup(){
	if( siteorigin_setting('social_ajax_comments') ) siteorigin_ajax_comments_activate();
	if( siteorigin_setting('social_share_post') ) siteorigin_share_activate();
	if( siteorigin_setting('navigation_responsive_menu') ) add_theme_support('siteorigin-mobilenav');
}
add_action('after_setup_theme', 'vantage_premium_setup', 15);

function vantage_premium_remove_credits(){
	return '';
}
add_filter('vantage_credits_siteorigin', 'vantage_premium_remove_credits');

/**
 * Show the social share icons
 */
function vantage_show_social_share(){
	if( siteorigin_setting('social_share_post') ) siteorigin_share_render( array(
		'twitter' => siteorigin_setting('social_twitter'),
	) );
}
add_action('vantage_after_single_entry', 'vantage_show_social_share');