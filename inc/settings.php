<?php
/**
 * Configure theme settings.
 *
 * @package sostarter
 * @since sostarter 1.0
 * @license GPL 2.0
 */

/**
 * Setup theme settings.
 * 
 * @since sostarter 1.0
 */
function sostarter_theme_settings(){
	siteorigin_settings_add_section('general', __('General', 'sostarter'));
	siteorigin_settings_add_section('home', __('Home Page', 'sostarter'));
	siteorigin_settings_add_section('layout', __('Layout', 'sostarter'));

	/**
	 * General Settings
	 */
	
	siteorigin_settings_add_field('general', 'logo', 'media', __('Logo', 'sostarter'), array(
		'choose' => __('Choose Image', 'sostarter'),
		'update' => __('Set Logo', 'sostarter'),
	));

	siteorigin_settings_add_field('general', 'site_description', 'checkbox', __('Site Description', 'sostarter'), array(
		'description' => __('Display your site description under your logo.', 'sostarter')
	));
	
	siteorigin_settings_add_teaser('general', 'ajax_comments', __('Ajax Comments', 'sostarter'), array(
		'description' => __('Keep your conversations flowing with ajax comments.', 'sostarter')
	));

	/**
	 * Home Page
	 */

	$slider_options = array('' => __('None', 'sostarter'));
	if(function_exists('siteorigin_slider_get_sliders')){
		$sliders = siteorigin_slider_get_sliders();
		foreach($sliders as $slider){
			$slider_options[$slider->ID] = $slider->post_title;
		}
		$description = null;
	}
	else{
		$description = sprintf(
			__('Display a slider on your home page. Requires <a href="%s">SiteOrigin Slider</a> plugin', 'sostarter'),
			siteorigin_plugin_activation_install_url('siteorigin-slider', __('SiteOrigin Slider', 'sostarter'), 'http://gpriday.s3.amazonaws.com/plugins/siteorigin-slider.zip')
		);
	}


	siteorigin_settings_add_field('home', 'slider', 'select', __('Home Page Slider', 'sostarter'), array(
		'description' =>$description,
		'options' => $slider_options
	));

	/**
	 * Layout Settings
	 */

	siteorigin_settings_add_field('layout', 'responsive', 'checkbox', __('Responsive Layout', 'sostarter'), array(
		'description' => __('Scale your layout for small screen devices.', 'sostarter')
	));
	
	siteorigin_settings_add_teaser('layout', 'responsive_menu', __('Responsive Menu', 'sostarter'), array(
		'description' => __('Use a special responsive menu for small screen devices.', 'sostarter')
	));
}
add_action('admin_init', 'sostarter_theme_settings');

/**
 * Setup theme default settings.
 * 
 * @param $defaults
 * @return mixed
 * @since sostarter 1.0
 */
function sostarter_theme_setting_defaults($defaults){
	$defaults['general_logo'] = '';
	$defaults['general_ajax_comments'] = false;
	$defaults['general_site_description'] = true;
	
	$defaults['home_slider'] = '';

	$defaults['layout_responsive'] = true;
	$defaults['layout_responsive_menu'] = true;

	return $defaults;
}
add_filter('siteorigin_theme_default_settings', 'sostarter_theme_setting_defaults');