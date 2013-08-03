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

function sostarter_premium_setup(){
	if(siteorigin_setting('general_ajax_comments')) siteorigin_ajax_comments_activate();
	if(siteorigin_setting('layout_responsive_menu')) add_theme_support('siteorigin-mobilenav');
}
add_action('after_setup_theme', 'sostarter_premium_setup', 15);

function sostarter_premium_remove_credits(){
	return '';
}
add_filter('sostarter_credits_siteorigin', 'sostarter_premium_remove_credits');

/**
 * This overwrites the show on front setting when we're displaying the blog archive page.
 *
 * @param $r
 * @return bool
 */
function sostarter_filter_show_on_front($r){
	/**
	 * @var WP_Query
	 */
	global $sostarter_is_blog_archive;
	if(!empty($sostarter_is_blog_archive)) {
		return false;
	}
	else return $r;
}
add_filter('option_show_on_front', 'sostarter_filter_show_on_front');

/**
 * Sets when we're displaying the blog archive page.
 *
 * @param $new
 */
function sostarter_set_is_blog_archive($new) {
	global $sostarter_is_blog_archive;
	$sostarter_is_blog_archive = $new;
}