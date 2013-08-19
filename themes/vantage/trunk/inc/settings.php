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
	siteorigin_settings_add_section('general', __('General', 'vantage'));
	siteorigin_settings_add_section('home', __('Home Page', 'vantage'));
	siteorigin_settings_add_section('layout', __('Layout', 'vantage'));

	/**
	 * General Settings
	 */
	
	siteorigin_settings_add_field('general', 'logo', 'media', __('Logo', 'vantage'), array(
		'choose' => __('Choose Image', 'vantage'),
		'update' => __('Set Logo', 'vantage'),
	));

	siteorigin_settings_add_field('general', 'site_description', 'checkbox', __('Site Description', 'vantage'), array(
		'description' => __('Display your site description under your logo.', 'vantage')
	));
	
	siteorigin_settings_add_teaser('general', 'ajax_comments', __('Ajax Comments', 'vantage'), array(
		'description' => __('Keep your conversations flowing with ajax comments.', 'vantage')
	));

	siteorigin_settings_add_field('general', 'use_sticky_menu', 'checkbox', __('Sticky Menu', 'vantage'), array(
		'description' => __('Sticks the menu to the top of the screen when a user scrolls down.', 'vantage')
	));

	siteorigin_settings_add_field('general', 'menu_search', 'checkbox', __('Search in Menu', 'vantage'), array(
		'description' => __('Display a search in the main menu.', 'vantage')
	));

	siteorigin_settings_add_field('general', 'display_scroll_to_top', 'checkbox', __('Display Scroll To Top', 'vantage'), array(
		'description' => __('Display a scroll-to-top button when a user scrolls down.', 'vantage')
	));

	/**
	 * Home Page
	 */

	$options = array('' => __('None', 'vantage'));

	if(class_exists('MetaSliderPlugin')){
		$sliders = get_posts(array(
			'post_type' => 'ml-slider',
		));

		foreach($sliders as $slider) {
			$options['meta:'.$slider->ID] = __('Slider: ', 'estate').$slider->post_title;
		}
	}

	siteorigin_settings_add_field('home', 'slider', 'select', __('Home Page Banner', 'estate'), array(
		'options' => $options,
		'description' => sprintf(
			__('This theme supports <a href="%s" target="_blank">Meta Slider</a>. <a href="%s">Install it</a> for free to create responsive, animated sliders - <a href="%s" target="_blank">More Info</a>', 'estate'),
			'http://sorig.in/metaslider',
			siteorigin_plugin_activation_install_url('ml-slider', __('Meta Slider', 'estate'), 'http://sorig.in/ml-slider'),
			'http://siteorigin.com/estate-documentation/sliders/'
		)
	));

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

	siteorigin_settings_add_teaser('layout', 'responsive_menu', __('Responsive Menu', 'vantage'), array(
		'description' => __('Use a special responsive menu for small screen devices.', 'vantage')
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
	$defaults['general_logo'] = '';
	$defaults['general_ajax_comments'] = false;
	$defaults['general_site_description'] = true;
	$defaults['general_use_sticky_menu'] = true;
	$defaults['general_menu_search'] = true;
	$defaults['general_display_scroll_to_top'] = true;

	$defaults['home_slider'] = '';

	$defaults['layout_responsive'] = true;
	$defaults['layout_bound'] = 'boxed';
	$defaults['layout_responsive_menu'] = true;

	return $defaults;
}
add_filter('siteorigin_theme_default_settings', 'vantage_theme_setting_defaults');