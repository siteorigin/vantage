<?php

function vantage_customizer_init(){

	$sections = apply_filters( 'vantage_premium_customizer_sections', array(
		'vantage_fonts' => array(
			'title' => __('Fonts', 'vantage'),
			'priority' => 30,
		),

		'vantage_menu' => array(
			'title' => __('Menu', 'vantage'),
			'priority' => 50,
		),

		'vantage_page' => array(
			'title' => __('Page', 'vantage'),
			'priority' => 55,
		),

		'vantage_footer' => array(
			'title' => __('Footer', 'vantage'),
			'priority' => 100,
		),

	) );

	$settings = apply_filters( 'vantage_premium_customizer_settings', array(
		// Fonts

		'vantage_fonts' => array(

			'body_font' => array(
				'type' => 'font',
				'title' => __('Body Font', 'vantage'),
				'default' => 'Helvetica Neue',
				'selector' => 'body,button,input,select,textarea',
			),

			'title_font' => array(
				'type' => 'font',
				'title' => __('Site Title Font', 'vantage'),
				'default' => 'Helvetica Neue',
				'selector' => 'header#masthead h1',
			),

			'heading_font' => array(
				'type' => 'font',
				'title' => __('Heading Font', 'vantage'),
				'default' => 'Helvetica Neue',
				'selector' => 'h1,h2,h3,h4,h5,h6',
			),

		),

		// The main menu

		'vantage_menu' => array(

			'background' => array(
				'type' => 'color',
				'title' => __('Background', 'vantage'),
				'default' => '#343538',
				'selector' => '.main-navigation',
				'property' => 'background-color',
			),

			'text' => array(
				'type' => 'color',
				'title' => __('Text Color', 'vantage'),
				'default' => '#e2e2e2',
				'selector' => '.main-navigation a',
				'property' => 'color',
			),

			'second_background' => array(
				'type' => 'color',
				'title' => __('Second Level Background', 'vantage'),
				'default' => '#464646',
				'selector' => '.main-navigation ul ul',
				'property' => 'background-color',
			),

			'second_text' => array(
				'type' => 'color',
				'title' => __('Second Level Text', 'vantage'),
				'default' => '#e2e2e2',
				'selector' => '.main-navigation ul ul a',
				'property' => 'color',
			),

			'hover_background' => array(
				'type' => 'color',
				'title' => __('Hover Background', 'vantage'),
				'default' => '#00bcff',
				'selector' => '.main-navigation ul li:hover > a, #search-icon #search-icon-icon:hover',
				'property' => 'background-color',
				'no_live' => true,
			),

			'hover_text' => array(
				'type' => 'color',
				'title' => __('Hover Text', 'vantage'),
				'default' => '#FFFFFF',
				'selector' => '.main-navigation ul li:hover > a, .main-navigation ul li:hover > a [class^="icon-"]',
				'property' => 'color',
				'no_live' => true,
			),

			'search' => array(
				'type' => 'color',
				'title' => __('Search Icon Background', 'vantage'),
				'default' => '#303134',
				'selector' => '#search-icon #search-icon-icon',
				'property' => 'background-color',
			),

			'search_input' => array(
				'type' => 'color',
				'title' => __('Search Input Background', 'vantage'),
				'default' => '#2d2e31',
				'selector' => '#search-icon .searchform',
				'property' => 'background-color',
			),

			'search_input_text' => array(
				'type' => 'color',
				'title' => __('Search Input Text', 'vantage'),
				'default' => '#d1d1d1',
				'selector' => '#search-icon .searchform input[name=s]',
				'property' => 'color',
			),

		),

		'vantage_page' => array(

			'masthead_background' => array(
				'type' => 'color',
				'title' => __('Masthead Background', 'vantage'),
				'default' => '#fcfcfc',
				'selector' => 'header#masthead',
				'property' => 'background-color',
			),

			'page_background' => array(
				'type' => 'color',
				'title' => __('Page Background', 'vantage'),
				'default' => '#fcfcfc',
				'selector' => '#main',
				'property' => 'background-color',
			),

		),

		'vantage_footer' => array(

			'background' => array(
				'type' => 'color',
				'title' => __('Footer Background', 'vantage'),
				'default' => '#2f3033',
				'selector' => '#colophon, body.layout-full',
				'property' => 'background-color',
			),

			'headings' => array(
				'type' => 'color',
				'title' => __('Headings', 'vantage'),
				'default' => '#e2e2e2',
				'selector' => '#footer-widgets .widget h1.widget-title',
				'property' => 'color',
			),

			'text' => array(
				'type' => 'color',
				'title' => __('Text', 'vantage'),
				'default' => '#b9b9b9',
				'selector' => '#footer-widgets .widget',
				'property' => 'color',
			),

			'links' => array(
				'type' => 'color',
				'title' => __('Links', 'vantage'),
				'default' => '#cccccc',
				'selector' => '#footer-widgets .widget a',
				'property' => 'color',
			),

			'site_into' => array(
				'type' => 'color',
				'title' => __('Site Info Text', 'vantage'),
				'default' => '#AAAAAA',
				'selector' => '#colophon #theme-attribution, #colophon #site-info',
				'property' => 'color',
			),

			'site_into_link' => array(
				'type' => 'color',
				'title' => __('Site Info Link', 'vantage'),
				'default' => '#DDDDDD',
				'selector' => '#colophon #theme-attribution a, #colophon #site-info a',
				'property' => 'color',
			),

		),


	) );

	// Include all the SiteOrigin customizer classes
	global $siteorigin_vantage_customizer;
	$siteorigin_vantage_customizer = new SiteOrigin_Customizer_Helper($settings, $sections, 'vantage');
}
add_action('init', 'vantage_customizer_init');

/**
 * @param WP_Customize_Manager $wp_customize
 */
function vantage_customizer_register($wp_customize){
	global $siteorigin_vantage_customizer;
	$siteorigin_vantage_customizer->customize_register($wp_customize);
}
add_action( 'customize_register', 'vantage_customizer_register', 15 );

/**
 * Display the styles
 */
function vantage_customizer_style() {
	global $siteorigin_vantage_customizer;
	$builder = $siteorigin_vantage_customizer->create_css_builder();

	// Add any extra CSS customizations
	echo $builder->css();
}
add_action('wp_head', 'vantage_customizer_style', 20);