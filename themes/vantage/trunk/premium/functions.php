<?php

define('SITEORIGIN_IS_PREMIUM', true);

// Include all the premium extras
include get_template_directory() . '/premium/extras/ajax-comments/ajax-comments.php';
include get_template_directory() . '/premium/extras/mobilenav/mobilenav.php';
include get_template_directory() . '/premium/extras/css/css.php';
include get_template_directory() . '/premium/extras/customizer/customizer.php';

// Theme specific files
include get_template_directory() . '/premium/inc/settings.php';
include get_template_directory() . '/premium/inc/customizer.php';

function vantage_premium_setup(){
	if(siteorigin_setting('social_ajax_comments')) siteorigin_ajax_comments_activate();
	if(siteorigin_setting('navigation_responsive_menu')) add_theme_support('siteorigin-mobilenav');
}
add_action('after_setup_theme', 'vantage_premium_setup', 15);

function vantage_premium_remove_credits(){
	return '';
}
add_filter('vantage_credits_siteorigin', 'vantage_premium_remove_credits');

/**
 * This overwrites the show on front setting when we're displaying the blog archive page.
 *
 * @param $r
 * @return bool
 */
function vantage_filter_show_on_front($r){
	/**
	 * @var WP_Query
	 */
	global $vantage_is_blog_archive;
	if(!empty($vantage_is_blog_archive)) {
		return false;
	}
	else return $r;
}
add_filter('option_show_on_front', 'vantage_filter_show_on_front');

/**
 * Sets when we're displaying the blog archive page.
 *
 * @param $new
 */
function vantage_set_is_blog_archive($new) {
	global $vantage_is_blog_archive;
	$vantage_is_blog_archive = $new;
}