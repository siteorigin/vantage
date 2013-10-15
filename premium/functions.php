<?php

define('SITEORIGIN_IS_PREMIUM', true);

// Include all the premium extras
include get_template_directory() . '/premium/extras/ajax-comments/ajax-comments.php';
include get_template_directory() . '/premium/extras/css/css.php';
include get_template_directory() . '/premium/extras/customizer/customizer.php';
include get_template_directory() . '/premium/extras/share/share.php';

// Theme specific files
include get_template_directory() . '/premium/inc/settings.php';
include get_template_directory() . '/premium/inc/customizer.php';
include get_template_directory() . '/premium/inc/panels.php';
include get_template_directory() . '/premium/inc/widgets.php';

function vantage_premium_setup(){
	if( siteorigin_setting('social_ajax_comments') ) siteorigin_ajax_comments_activate();
	if( siteorigin_setting('social_share_post') ) siteorigin_share_activate();

	if( siteorigin_setting('navigation_responsive_menu') ) {
		include get_template_directory() . '/premium/extras/mobilenav/mobilenav.php';
	}
}
add_action('after_setup_theme', 'vantage_premium_setup', 15);

function vantage_premium_remove_credits(){
	return '';
}
add_filter('vantage_footer_attribution', 'vantage_premium_remove_credits');

function vantage_premium_enqueue_styles(){
	wp_enqueue_style('vantage-premium', get_template_directory_uri().'/premium/style.css', array(), SITEORIGIN_THEME_VERSION);
}
add_action('wp_enqueue_scripts', 'vantage_premium_enqueue_styles', 11);

/**
 * Show the social share icons
 */
function vantage_premium_show_social_share(){
	if( siteorigin_setting('social_share_post') && is_single() ) {
		siteorigin_share_render( array(
			'twitter' => siteorigin_setting('social_twitter'),
		) );
	}
}
add_action('vantage_entry_main_bottom', 'vantage_premium_show_social_share');

function vantage_premium_logo_retina($attr){
	$logo = siteorigin_setting( 'logo_image_retina' );
	if( $logo ) {
		$image = wp_get_attachment_image_src($logo, 'full');

		// Ignore empty images
		if(empty($image)) return $attr;
		list ($src, $height, $width) = $image;

		$attr['data-retina-image'] = $src;
	}

	return $attr;
}
add_filter('vantage_logo_image_attributes', 'vantage_premium_logo_retina');

function vantage_premium_filter_mobilenav($text){
	if( siteorigin_setting('navigation_responsive_menu_text') ) {
		$text['navigate'] = siteorigin_setting('navigation_responsive_menu_text');
	}

	return $text;
}
add_filter('siteorigin_mobilenav_text', 'vantage_premium_filter_mobilenav');

function vantage_premium_filter_mobilenav_collapse($collpase){
	return siteorigin_setting('navigation_responsive_menu_collapse');
}
add_filter('siteorigin_mobilenav_resolution', 'vantage_premium_filter_mobilenav_collapse');