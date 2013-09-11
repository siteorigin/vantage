<?php
/**
 * Configure theme settings.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

/**
 * Setup theme settings.
 * 
 * @since vantage 1.0
 */
function vantage_theme_settings(){
	siteorigin_settings_add_section( 'logo', __('Logo', 'vantage' ) );
	siteorigin_settings_add_section( 'layout', __('Layout', 'vantage' ) );
	siteorigin_settings_add_section( 'home', __('Home', 'vantage' ) );
	siteorigin_settings_add_section( 'navigation', __('Navigation', 'vantage' ) );
	siteorigin_settings_add_section( 'blog', __('Blog', 'vantage' ) );
	siteorigin_settings_add_section( 'social', __('Social', 'vantage' ) );
	siteorigin_settings_add_section( 'general', __('General', 'vantage' ) );

	/**
	 * Logo Settings
	 */

	siteorigin_settings_add_field('logo', 'image', 'media', __('Logo Image', 'vantage'), array(
		'choose' => __('Choose Image', 'vantage'),
		'update' => __('Set Logo', 'vantage'),
		'description' => __('Your own custom logo.', 'vantage')
	) );

	siteorigin_settings_add_field('logo', 'header_text', 'text', __('Header Text', 'vantage'), array(
		'description' => __('Text that appears to the right of your logo.', 'vantage')
	) );

	/**
	 * Layout Settings
	 */

	siteorigin_settings_add_field('layout', 'responsive', 'checkbox', __('Responsive Layout', 'vantage'), array(
		'description' => __('Scale your layout for small screen devices.', 'vantage')
	));

	siteorigin_settings_add_field('layout', 'bound', 'select', __('Layout Bound', 'vantage'), array(
		'options' => array(
			'boxed' => __('Boxed', 'vantage'),
			'full' => __('Full Width', 'vantage'),
		),
		'description' => __('Use a special responsive menu for small screen devices.', 'vantage')
	));

	/**
	 * Navigation settings
	 */

	siteorigin_settings_add_teaser('navigation', 'responsive_menu', __('Responsive Menu', 'vantage'), array(
		'description' => __('Use a special responsive menu for small screen devices.', 'vantage')
	));

	siteorigin_settings_add_field('navigation', 'use_sticky_menu', 'checkbox', __('Sticky Menu', 'vantage'), array(
		'description' => __('Sticks the menu to the top of the screen when a user scrolls down.', 'vantage')
	));

	siteorigin_settings_add_field('navigation', 'menu_search', 'checkbox', __('Search in Menu', 'vantage'), array(
		'description' => __('Display a search in the main menu.', 'vantage')
	));

	siteorigin_settings_add_field('navigation', 'display_scroll_to_top', 'checkbox', __('Display Scroll To Top', 'vantage'), array(
		'description' => __('Display a scroll-to-top button when a user scrolls down.', 'vantage')
	));

	/**
	 * Home Page
	 */

	siteorigin_settings_add_field('home', 'slider', 'select', __('Home Page Slider', 'vantage'), array(
		'options' => siteorigin_metaslider_get_options(true),
		'description' => sprintf(
			__('This theme supports <a href="%s" target="_blank">Meta Slider</a>. <a href="%s">Install it</a> for free to create responsive, animated sliders - <a href="%s" target="_blank">More Info</a>', 'vantage'),
			'http://sorig.in/metaslider',
			siteorigin_metaslider_install_link(),
			'http://siteorigin.com/vantage-documentation/sliders/'
		)
	));

	siteorigin_settings_add_field('home', 'slider_stretch', 'checkbox', __('Stretch Home Slider', 'vantage'), array(
		'label' => __('Stretch', 'vantage'),
		'description' => __('Stretch the home page slider to the width of the screen if using the full width layout.', 'vantage'),
	) );

	/**
	 * Blog Settings
	 */

	siteorigin_settings_add_field('blog', 'post_author', 'checkbox', __('Post Author', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post author in blog archive pages.', 'vantage')
	));

	siteorigin_settings_add_field('blog', 'post_date', 'checkbox', __('Post Date', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post date.', 'vantage')
	));

	siteorigin_settings_add_teaser('blog', 'author_bio', __('Author Bio', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post date.', 'vantage')
	));

	/**
	 * Social Settings
	 */

	siteorigin_settings_add_teaser('social', 'ajax_comments', __('Ajax Comments', 'vantage'), array(
		'description' => __('Keep your conversations flowing with ajax comments.', 'vantage')
	));

	siteorigin_settings_add_teaser('social', 'share_post', __('Post Sharing', 'vantage'), array(
		'description' => __('Show icons to share your posts on Facebook, Twitter and Google+.', 'vantage')
	));

	siteorigin_settings_add_teaser('social', 'twitter', __('Twitter Handle', 'vantage'), array(
		'description' => __('This handle will be recommended after a user shares one of your posts.', 'vantage')
	));


}
add_action('admin_init', 'vantage_theme_settings');

/**
 * Setup theme default settings.
 * 
 * @param $defaults
 * @return mixed
 * @since vantage 1.0
 */
function vantage_theme_setting_defaults($defaults){
	$defaults['logo_image'] = array(
		get_template_directory_uri().'/images/logo.png', 40, 181
	);

	$defaults['logo_header_text'] = __('Call me! Maybe?', 'vantage');


	$defaults['layout_responsive'] = true;
	$defaults['layout_bound'] = 'full';

	$defaults['navigation_responsive_menu'] = true;
	$defaults['navigation_use_sticky_menu'] = true;
	$defaults['navigation_menu_search'] = true;
	$defaults['navigation_display_scroll_to_top'] = true;

	$defaults['home_slider'] = 'demo';
	$defaults['home_slider_stretch'] = true;

	$defaults['blog_post_author'] = true;
	$defaults['blog_post_date'] = true;
	$defaults['blog_author_bio'] = false;

	$defaults['social_ajax_comments'] = true;
	$defaults['social_share_post'] = true;
	$defaults['social_twitter'] = '';

	return $defaults;
}
add_filter('siteorigin_theme_default_settings', 'vantage_theme_setting_defaults');