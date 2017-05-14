<?php

include get_template_directory() . '/inc/customizer/customizer.php';

function vantage_customizer_init(){
	$sections = apply_filters( 'vantage_premium_customizer_sections', array(
		'vantage_fonts' => array(
			'title' => __('Fonts', 'vantage'),
			'priority' => 30,
		),
		'vantage_general' => array(
			'title' => __('General', 'vantage'),
			'priority' => 40,
		),
		'vantage_menu' => array(
			'title' => __('Menu', 'vantage'),
			'priority' => 50,
		),
		'vantage_mobile_menu' => array(
			'title' => __('Mobile Menu', 'vantage'),
			'priority' => 60,
		),
		'vantage_buttons' => array(
			'title' => __('Buttons', 'vantage'),
			'priority' => 65,
		),
		'vantage_widgets' => array(
			'title' => __('Widgets', 'vantage'),
			'priority' => 70,
		),
		'vantage_page' => array(
			'title' => __('Page', 'vantage'),
			'priority' => 80,
		),
		'vantage_sidebar' => array(
			'title' => __('Sidebar', 'vantage'),
			'priority' => 90,
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
				'selector' => '#masthead h1',
			),
			'heading_font' => array(
				'type' => 'font',
				'title' => __('Heading Font', 'vantage'),
				'default' => 'Helvetica Neue',
				'selector' => 'h1,h2,h3,h4,h5,h6',
			),
			'menu_font' => array(
				'type' => 'font',
				'title' => __('Menu Font', 'vantage'),
				'default' => 'Helvetica Neue',
				'selector' => '.main-navigation, .mobile-nav-frame, .mobile-nav-frame .title h3',
			),
			// Font sizes
			'site_title_size' => array(
				'type' => 'measurement',
				'title' => __('Site Title Size', 'vantage'),
				'default' => 36,
				'unit' => 'px',
				'callback' => 'vantage_customizer_callback_site_title_size',
			),
			'site_title_color' => array(
				'type' => 'color',
				'title' => __('Site Title Color', 'vantage'),
				'default' => '#666666',
				'selector' => '#masthead .hgroup h1, #masthead.masthead-logo-in-menu .logo > h1',
				'property' => array('color'),
			),
			'header_text_size' => array(
				'type' => 'measurement',
				'title' => __('Header Text Size', 'vantage'),
				'default' => 13,
				'unit' => 'px',
				'selector' => '#masthead .hgroup .support-text',
				'property' => array('font-size'),
			),
			'header_text_color' => array(
				'type' => 'color',
				'title' => __('Header Text Color', 'vantage'),
				'default' => '#4b4b4b',
				'selector' => '#masthead .hgroup .support-text',
				'property' => array('color'),
			),
			'page_title_size' => array(
				'type' => 'measurement',
				'title' => __('Page Title Size', 'vantage'),
				'default' => 20,
				'unit' => 'px',
				'selector' => '#page-title, article.post .entry-header h1.entry-title, article.page .entry-header h1.entry-title',
				'property' => array('font-size'),
			),
			'page_title_color' => array(
				'type' => 'color',
				'title' => __('Page Title Color', 'vantage'),
				'default' => '#3b3b3b',
				'selector' => '#page-title, article.post .entry-header h1.entry-title, article.page .entry-header h1.entry-title',
				'property' => array('color'),
			),			
			'content_size' => array(
				'type' => 'measurement',
				'title' => __('Content Size', 'vantage'),
				'default' => 13,
				'unit' => 'px',
				'selector' => '.entry-content',
				'property' => array('font-size'),
			),
			'content_color' => array(
				'type' => 'color',
				'title' => __('Content Color', 'vantage'),
				'default' => '#666666',
				'selector' => '.entry-content, #comments .commentlist article .comment-meta a',
				'property' => array('color'),
			),
			'content_heading_color' => array(
				'type' => 'color',
				'title' => __('Content Heading Color', 'vantage'),
				'default' => '#444444',
				'callback' => 'vantage_customizer_callback_heading_color',
			),
			'content_heading_one_size' => array(
				'type' => 'measurement',
				'title' => __('Content Heading 1 Size', 'vantage'),
				'default' => 22,
				'unit' => 'px',
				'selector' => '.entry-content h1',
				'property' => array('font-size'),
			),
			'content_heading_two_size' => array(
				'type' => 'measurement',
				'title' => __('Content Heading 2 Size', 'vantage'),
				'default' => 21,
				'unit' => 'px',
				'selector' => '.entry-content h2',
				'property' => array('font-size'),
			),
			'content_heading_three_size' => array(
				'type' => 'measurement',
				'title' => __('Content Heading 3 Size', 'vantage'),
				'default' => 20,
				'unit' => 'px',
				'selector' => '.entry-content h3',
				'property' => array('font-size'),
			),
			'content_heading_four_size' => array(
				'type' => 'measurement',
				'title' => __('Content Heading 4 Size', 'vantage'),
				'default' => 18,
				'unit' => 'px',
				'selector' => '.entry-content h4',
				'property' => array('font-size'),
			),
			'content_heading_five_size' => array(
				'type' => 'measurement',
				'title' => __('Content Heading 5 Size', 'vantage'),
				'default' => 16,
				'unit' => 'px',
				'selector' => '.entry-content h5',
				'property' => array('font-size'),
			),
			'content_heading_six_size' => array(
				'type' => 'measurement',
				'title' => __('Content Heading 6 Size', 'vantage'),
				'default' => 14,
				'unit' => 'px',
				'selector' => '.entry-content h6',
				'property' => array('font-size'),
			),
		),
		'vantage_general' => array(
			'header_padding' => array(
				'type' => 'measurement',
				'title' => __('Header Padding', 'vantage'),
				'default' => 45,
				'unit' => 'px',
				'selector' => '#masthead .hgroup',
				'property' => array('padding-top', 'padding-bottom'),
			),
			'logo_centered' => array(
				'type' => 'checkbox',
				'title' => __('Center Logo', 'vantage'),
				'default' => false,
				'callback' => 'vantage_customizer_callback_logo_center',
			),
			'link_color' => array(
				'type' => 'color',
				'title' => __('Content Link Color', 'vantage'),
				'default' => '#248cc8',
				'selector' => '.entry-content a, .entry-content a:visited, article.post .author-box .box-content .author-posts a:hover, #secondary a, #secondary a:visited, #masthead .hgroup a, #masthead .hgroup a:visited, .comment-form .logged-in-as a, .comment-form .logged-in-as a:visited',
				'property' => 'color',
				'no_live' => true,
			),
			'link_underline' => array(
				'type' => 'checkbox',
				'title' => __('Remove Link Underline', 'vantage'),
				'default' => false,
				'callback' => 'vantage_customizer_callback_link_underline',
			),
			'link_hover_color' => array(
				'type' => 'color',
				'title' => __('Content Link Hover Color', 'vantage'),
				'default' => '#f47e3c',
				'selector' => '.entry-content a:hover, .entry-content a:focus, .entry-content a:active, #secondary a:hover, #masthead .hgroup a:hover, #masthead .hgroup a:focus, #masthead .hgroup a:active, .comment-form .logged-in-as a:hover, .comment-form .logged-in-as a:focus, .comment-form .logged-in-as a:active',
				'property' => 'color',
				'no_live' => true,
			),
			'link_hover_underline' => array(
				'type' => 'checkbox',
				'title' => __('Add Link Underline on Hover', 'vantage'),
				'default' => false,
				'callback' => 'vantage_customizer_callback_link_hover_underline',
			),
		),
		// The main menu
		'vantage_menu' => array(
			'menu_alignment' => array(
				'type' => 'select',
				'title' => __('Menu Alignment', 'vantage'),
				'default' => 'left',
				'selector' => '.main-navigation ul',
				'property' => 'text-align',
				'choices' => array(
					'left' => __( 'Left', 'vantage' ),
					'right' => __( 'Right', 'vantage' ),
					'center' => __( 'Center', 'vantage' ),
				),
			),
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
				'default' => '#ffffff',
				'selector' => '.main-navigation ul li:hover > a, .main-navigation ul li:hover > a [class^="fa fa-"]',
				'property' => 'color',
				'no_live' => true,
			),
			'hover_background_second' => array(
				'type' => 'color',
				'title' => __('Second Level Hover', 'vantage'),
				'default' => '#00bcff',
				'selector' => '.main-navigation ul ul li:hover > a',
				'property' => 'background-color',
				'no_live' => true,
			),
			'hover_text_second' => array(
				'type' => 'color',
				'title' => __('Second Level Hover Text', 'vantage'),
				'default' => '#ffffff',
				'selector' => '.main-navigation ul ul li:hover > a',
				'property' => 'color',
				'no_live' => true,
			),
			'icon_color' => array(
				'type' => 'color',
				'title' => __('Icon Color', 'vantage'),
				'default' => '#cccccc',
				'selector' => '.main-navigation [class^="fa fa-"], .main-navigation .mobile-nav-icon',
				'property' => 'color',
			),
			'icon_hover_color' => array(
				'type' => 'color',
				'title' => __('Icon Hover Color', 'vantage'),
				'default' => '#ffffff',
				'selector' => '.main-navigation ul li:hover > a [class^="fa fa-"], .main-navigation ul li:hover > a .mobile-nav-icon',
				'property' => 'color',
				'no_live' => true,
			),
			'current_background' => array(
				'type' => 'color',
				'title' => __('Current Page Background', 'vantage'),
				'default' => '#343538',
				'selector' => '.main-navigation ul li.current-menu-item > a, .main-navigation ul li.current_page_item > a ',
				'property' => 'background-color',
				'no_live' => true,
			),
			'current_text' => array(
				'type' => 'color',
				'title' => __('Current Page Text', 'vantage'),
				'default' => '#ffffff',
				'selector' => '.main-navigation ul li.current-menu-item > a, .main-navigation ul li.current-menu-item > a [class^="fa fa-"], .main-navigation ul li.current-page-item > a, .main-navigation ul li.current-page-item > a [class^="fa fa-"]',
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
			'search_icon' => array(
				'type' => 'color',
				'title' => __('Search Icon Color', 'vantage'),
				'default' => '#d1d1d1',
				'selector' => '#search-icon #search-icon-icon .vantage-icon-search',
				'property' => 'color',
			),
			'search_icon_hover' => array(
				'type' => 'color',
				'title' => __('Search Icon Hover Color', 'vantage'),
				'default' => '#ffffff',
				'selector' => '#search-icon #search-icon-icon:hover .vantage-icon-search',
				'property' => 'color',
				'no_live' => true,
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
			'topbottom_padding' => array(
				'type' => 'measurement',
				'title' => __('Menu Item Vertical Padding (px)', 'vantage'),
				'default' => 20,
				'unit' => 'px',
				'selector' => '.main-navigation ul li a',
				'property' => array('padding-top', 'padding-bottom'),
				'no_live' => true,
			),
			'leftright_padding' => array(
				'type' => 'measurement',
				'title' => __('Menu Item Horizontal Padding (px)', 'vantage'),
				'default' => 35,
				'unit' => 'px',
				'selector' => '.main-navigation ul li a, #masthead.masthead-logo-in-menu .logo',
				'property' => array('padding-left', 'padding-right'),
			),
			'font_size' => array(
				'type' => 'measurement',
				'title' => __('Menu Font Size', 'vantage'),
				'default' => 13,
				'unit' => 'px',
				'selector' => '.main-navigation ul li',
				'property' => array('font-size'),
			),
			'widget_menu_border' => array(
				'type' => 'color',
				'title' => __('Header Widget Menu Border Color', 'vantage'),
				'default' => '#00bcff',
				'selector' => '#header-sidebar .widget_nav_menu ul.menu > li > ul.sub-menu',
				'property' => array('border-top-color'),
				'no_live' => true,
			),
		),
		'vantage_mobile_menu' => array(
			'background' => array(
				'type' => 'color',
				'title' => __('Background', 'vantage'),
				'default' => '#222222',
				'selector' => '.mobile-nav-frame',
				'property' => 'background-color',
			),
			'title' => array(
				'type' => 'color',
				'title' => __('Title Text', 'vantage'),
				'default' => '#ffffff',
				'selector' => '.mobile-nav-frame .title h3, .mobile-nav-frame .title .close, .mobile-nav-frame .title .back',
				'property' => 'color',
			),
			'title_background' => array(
				'type' => 'color',
				'title' => __('Title Background', 'vantage'),
				'default' => '#161616',
				'selector' => '.mobile-nav-frame .title',
				'property' => 'background-color',
			),
			'search_background' => array(
				'type' => 'color',
				'title' => __('Search Background', 'vantage'),
				'default' => '#e0e0e0',
				'selector' => '.mobile-nav-frame form.search input[type=search]',
				'property' => 'background-color',
			),
			'menu' => array(
				'type' => 'color',
				'title' => __('Menu Text', 'vantage'),
				'default' => '#f3f3f3',
				'selector' => '.mobile-nav-frame ul li a.link, .mobile-nav-frame .next',
				'property' => 'color',
			),
			'menu_background' => array(
				'type' => 'color',
				'title' => __('Menu Background', 'vantage'),
				'default' => '#212121',
				'selector' => '.mobile-nav-frame ul',
				'property' => 'background-color',
			),
			'menu_border' => array(
				'type' => 'color',
				'title' => __('Menu Border', 'vantage'),
				'default' => '#111111',
				'selector' => '.mobile-nav-frame ul',
				'property' => 'border-color',
			),
		),
		'vantage_buttons' => array(
			'button_background' => array(
				'type' => 'color',
				'title' => __('Button Background Color', 'vantage'),
				'default' => '#dfdfdf',
				'callback' => 'vantage_customizer_callback_button_background',
			),
			'button_color' => array(
				'type' => 'color',
				'title' => __('Button Color', 'vantage'),
				'default' => '#646464',
				'selector' => 'a.button, button, html input[type="button"], input[type="reset"], input[type="submit"], .post-navigation a, #image-navigation a, article.post .more-link, article.page .more-link, .paging-navigation a, .woocommerce #page-wrapper .button, .woocommerce a.button, .woocommerce .checkout-button, .woocommerce input.button, .woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled], .woocommerce input.button:disabled:hover, .woocommerce input.button:disabled[disabled]:hover, #infinite-handle span button',
				'property' => 'color',
			),
			'button_border' => array(
				'type' => 'color',
				'title' => __('Button Border Color', 'vantage'),
				'default' => '#c3c3c3',
				'callback' => 'vantage_customizer_callback_button_border',
			),
			'button_text_shadow' => array(
				'type' => 'checkbox',
				'title' => __('Button Text Shadow', 'vantage'),
				'default' => true,
				'callback' => 'vantage_customizer_callback_button_text_shadow',
			),
			'button_shadow' => array(
				'type' => 'checkbox',
				'title' => __('Button Shadow', 'vantage'),
				'default' => true,
				'callback' => 'vantage_customizer_callback_button_shadow',
			),
			'secondary_button_background' => array(
				'type' => 'color',
				'title' => __('Checkout Button Background Color', 'vantage'),
				'default' => '#00bcff',
				'callback' => 'vantage_customizer_callback_button_woo_background',
			),
			'secondary_button_color' => array(
				'type' => 'color',
				'title' => __('Checkout Button Color', 'vantage'),
				'default' => '#ffffff',
				'selector' => '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt:focus, .woocommerce a.button.alt:focus, .woocommerce button.button.alt:focus, .woocommerce input.button.alt:focus',
				'property' => 'color',
			),
			'secondary_button_border' => array(
				'type' => 'color',
				'title' => __('Checkout Button Border Color', 'vantage'),
				'default' => '#646464',
				'selector' => '.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt:focus, .woocommerce a.button.alt:focus, .woocommerce button.button.alt:focus, .woocommerce input.button.alt:focus',
				'property' => 'border-color',
			),
		),
		'vantage_widgets' => array(
			'masthead' => array(
				'type' => 'color',
				'title' => __(' Masthead Widget Titles', 'vantage'),
				'default' => '#3b3b3b',
				'selector' => '#masthead-widgets .widget .widget-title',
				'property' => 'color',
			),
			'circle_icon_bg' => array(
				'type' => 'color',
				'title' => __('Circle Icon Widget Background', 'vantage'),
				'default' => '#3a3b3e',
				'selector' => '.widget_circleicon-widget .circle-icon-box .circle-icon:not(.icon-style-set)',
				'property' => 'background-color',
			),
			'circle_icon_icon' => array(
				'type' => 'color',
				'title' => __('Circle Icon Widget Icon', 'vantage'),
				'default' => '#ffffff',
				'selector' => '.widget_circleicon-widget .circle-icon-box .circle-icon [class^="fa fa-"]:not(.icon-color-set)',
				'property' => 'color',
			),
		),
		'vantage_page' => array(
			'masthead_background' => array(
				'type' => 'color',
				'title' => __('Masthead Background', 'vantage'),
				'default' => '#fcfcfc',
				'selector' => '#masthead',
				'property' => 'background-color',
			),
			'masthead_background_image' => array(
				'type' => 'image',
				'title' => __('Masthead Background Image', 'vantage'),
				'default' => false,
				'selector' => '#masthead',
				'property' => 'background-image',
			),
			'masthead_background_image_layout' => array(
				'type' => 'select',
				'title' => __('Masthead Background Image Layout', 'vantage'),
				'default' => '',
				'selector' => '#masthead',
				'choices' => array(
					'' => __( 'Default', 'vantage' ),
					'center' => __( 'Center', 'vantage' ),
					'tile' => __( 'Tile', 'vantage' ),
					'cover' => __( 'Cover', 'vantage' ),
				),
				'callback' => 'vantage_customizer_callback_image_layout'
			),
			'page_background' => array(
				'type' => 'color',
				'title' => __('Page Background', 'vantage'),
				'default' => '#fcfcfc',
				'selector' => '#main',
				'property' => 'background-color',
			),
			'page_background_image' => array(
				'type' => 'image',
				'title' => __('Page Background Image', 'vantage'),
				'default' => false,
				'selector' => '#main',
				'property' => 'background-image',
			),
			'page_background_image_layout' => array(
				'type' => 'select',
				'title' => __('Page Background Image Layout', 'vantage'),
				'default' => '',
				'selector' => '#main',
				'choices' => array(
					'' => __( 'Default', 'vantage' ),
					'center' => __( 'Center', 'vantage' ),
					'tile' => __( 'Tile', 'vantage' ),
					'cover' => __( 'Cover', 'vantage' ),
				),
				'callback' => 'vantage_customizer_callback_image_layout'
			),
			'image_shadow' => array(
				'type' => 'checkbox',
				'title' => __('Image Shadow and Rounding', 'vantage'),
				'default' => false,
				'callback' => 'vantage_customizer_callback_image_shadow',
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
			'background_image' => array(
				'type' => 'image',
				'title' => __('Footer Background Image', 'vantage'),
				'default' => false,
				'selector' => '#colophon',
				'property' => 'background-image',
			),
			'footer_background_image_layout' => array(
				'type' => 'select',
				'title' => __('Footer Background Image Layout', 'vantage'),
				'default' => '',
				'selector' => '#colophon',
				'choices' => array(
					'' => __( 'Default', 'vantage' ),
					'center' => __( 'Center', 'vantage' ),
					'tile' => __( 'Tile', 'vantage' ),
					'cover' => __( 'Cover', 'vantage' ),
				),
				'callback' => 'vantage_customizer_callback_image_layout'
			),
			'headings' => array(
				'type' => 'color',
				'title' => __('Widget Titles', 'vantage'),
				'default' => '#e2e2e2',
				'selector' => '#footer-widgets .widget .widget-title',
				'property' => 'color',
			),
			'text' => array(
				'type' => 'color',
				'title' => __('Text', 'vantage'),
				'default' => '#b9b9b9',
				'callback' => 'vantage_customizer_callback_footer_color'
			),
			'links' => array(
				'type' => 'color',
				'title' => __('Link Color', 'vantage'),
				'default' => '#cccccc',
				'selector' => '#footer-widgets .widget a, #footer-widgets .widget a:visited',
				'property' => 'color',
			),
			'link_hover' => array(
				'type' => 'color',
				'title' => __('Link Hover Color', 'vantage'),
				'default' => '#cccccc',
				'selector' => '#footer-widgets .widget a:hover, #footer-widgets .widget a:focus, #footer-widgets .widget a:active',
				'property' => 'color',
			),
			'site_into' => array(
				'type' => 'color',
				'title' => __('Site Info Text', 'vantage'),
				'default' => '#aaaaaa',
				'selector' => '#colophon #theme-attribution, #colophon #site-info',
				'property' => 'color',
			),
			'site_into_link' => array(
				'type' => 'color',
				'title' => __('Site Info Link', 'vantage'),
				'default' => '#dddddd',
				'selector' => '#colophon #theme-attribution a, #colophon #site-info a',
				'property' => 'color',
			),
			'scroll_to_top_color' => array(
				'type' => 'color',
				'title' => __('Scroll to Top Color ', 'vantage'),
				'default' => '#ffffff',
				'selector' => '#scroll-to-top .vantage-icon-arrow-up',
				'property' => 'color',
			),
			'scroll_to_top_background' => array(
				'type' => 'color',
				'title' => __('Scroll to Top Background', 'vantage'),
				'default' => '#000000',
				'selector' => '#scroll-to-top',
				'property' => 'background',
			),
		),
		'vantage_sidebar' => array(
			'position' => array(
				'type' => 'select',
				'title' => __('Sidebar Position', 'vantage'),
				'default' => 'right',
				'choices' => array(
					'none'   => __( 'None', 'vantage' ),
					'left'   => __( 'Left', 'vantage' ),
					'right'  => __( 'Right', 'vantage' )
				),
				'no_live' => true
			)
		),
	) );

	if( !class_exists( 'WooCommerce' ) ) {
		unset( $settings['vantage_buttons']['secondary_button_background'], $settings['vantage_buttons']['secondary_button_color'], $settings['vantage_buttons']['secondary_button_border'] );
	}

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
	if( empty($siteorigin_vantage_customizer) ) return;
	$builder = $siteorigin_vantage_customizer->create_css_builder();
	// Add any extra CSS customizations
	echo $builder->css();
}
add_action('wp_head', 'vantage_customizer_style', 20);
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_site_title_size($builder, $val, $setting){
	$mh_layout = siteorigin_setting( 'layout_masthead' );
	if ( $mh_layout == 'logo-in-menu' ) {
		$builder->add_css('#masthead .hgroup h1, #masthead.masthead-logo-in-menu .logo > h1', 'font-size', $val*0.6 . 'px');
	} else {
		$builder->add_css('#masthead .hgroup h1, #masthead.masthead-logo-in-menu .logo > h1', 'font-size', $val . 'px');
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_logo_center($builder, $val, $setting){
	if( $val ) {
		$builder->add_css('#masthead .hgroup .logo', 'text-align', 'center');
		$builder->add_css('#masthead .hgroup .logo, #masthead .hgroup .site-logo-link', 'float', 'none');
		$builder->add_css('#masthead .hgroup .logo img, #masthead .hgroup .site-logo-link img', 'display', 'block');
		$builder->add_css('#masthead .hgroup .logo img, #masthead .hgroup .site-logo-link img', 'margin', '0 auto');
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_image_shadow($builder, $val, $setting){
	if( $val ) {
		$builder->add_css('.entry-content img', '-webkit-border-radius', '3px');
		$builder->add_css('.entry-content img', '-moz-border-radius', '3px');
		$builder->add_css('.entry-content img', 'border-radius', '3px');
		$builder->add_css('.entry-content img', '-webkit-box-shadow', '0 1px 2px rgba(0,0,0,0.175)');
		$builder->add_css('.entry-content img', '-moz-box-shadow', '0 1px 2px rgba(0,0,0,0.175)');
		$builder->add_css('.entry-content img', 'box-shadow', '0 1px 2px rgba(0,0,0,0.175)');
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_link_underline($builder, $val, $setting){
	if( $val ) {
		$builder->add_css('.entry-content a, .textwidget a', 'text-decoration', 'none');
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_link_hover_underline($builder, $val, $setting){
	if( $val ) {
		$builder->add_css('.entry-content a:hover, .textwidget a:hover', 'text-decoration', 'underline');
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_footer_color($builder, $val, $setting){
	if( $val ) {
		$builder->add_css('#footer-widgets .widget', 'color', $val);
		$builder->add_css('#colophon .widget_nav_menu .menu-item a', 'border-color', $val);
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_heading_color($builder, $val, $setting){
	if( $val ) {
		$builder->add_css('.entry-content h1, .entry-content h2, .entry-content h3, .entry-content h4, .entry-content h5, .entry-content h6, #comments .commentlist article .comment-author a, #comments .commentlist article .comment-author, #comments-title, #reply-title, #commentform label', 'color', $val);
		$builder->add_css('#comments-title, #reply-title', 'border-bottom-color', $val);
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_button_background($builder, $val, $setting){
	if( $val ) {
		$builder->add_css('a.button, button, html input[type="button"], input[type="reset"], input[type="submit"], .post-navigation a, #image-navigation a, article.post .more-link, article.page .more-link, .paging-navigation a, .woocommerce #page-wrapper .button, .woocommerce a.button, .woocommerce .checkout-button, .woocommerce input.button, #infinite-handle span', 'background', $val);
		$builder->add_css('a.button:hover, button:hover, html input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .post-navigation a:hover, #image-navigation a:hover, article.post .more-link:hover, article.page .more-link:hover, .paging-navigation a:hover, .woocommerce #page-wrapper .button:hover, .woocommerce a.button:hover, .woocommerce .checkout-button:hover, .woocommerce input.button:hover, .woocommerce input.button:disabled:hover, .woocommerce input.button:disabled[disabled]:hover, #infinite-handle span:hover', 'background', $val);
		$builder->add_css('a.button:hover, button:hover, html input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .post-navigation a:hover, #image-navigation a:hover, article.post .more-link:hover, article.page .more-link:hover, .paging-navigation a:hover, .woocommerce #page-wrapper .button:hover, .woocommerce a.button:hover, .woocommerce .checkout-button:hover, .woocommerce input.button:hover, #infinite-handle span:hover', 'opacity', '0.75');
		$builder->add_css('a.button:focus, button:focus, html input[type="button"]:focus, input[type="reset"]:focus, input[type="submit"]:focus, .post-navigation a:focus, #image-navigation a:focus, article.post .more-link:focus, article.page .more-link:focus, .paging-navigation a:focus, .woocommerce #page-wrapper .button:focus, .woocommerce a.button:focus, .woocommerce .checkout-button:focus, .woocommerce input.button:focus, .woocommerce input.button:disabled:focus, .woocommerce input.button:disabled[disabled]:focus, #infinite-handle span:focus', 'background', $val);
		$builder->add_css('a.button:focus, button:focus, html input[type="button"]:focus, input[type="reset"]:focus, input[type="submit"]:focus, .post-navigation a:focus, #image-navigation a:focus, article.post .more-link:focus, article.page .more-link:focus, .paging-navigation a:focus, .woocommerce #page-wrapper .button:focus, .woocommerce a.button:focus, .woocommerce .checkout-button:focus, .woocommerce input.button:focus, #infinite-handle span:focus', 'opacity', '0.75');
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_button_border($builder, $val, $setting){
	if( $val ) {
		$builder->add_css('a.button, button, html input[type="button"], input[type="reset"], input[type="submit"], .post-navigation a, #image-navigation a, article.post .more-link, article.page .more-link, .paging-navigation a, .woocommerce #page-wrapper .button, .woocommerce a.button, .woocommerce .checkout-button, .woocommerce input.button, #infinite-handle span', 'border-color', $val);
		$builder->add_css('a.button:hover, button:hover, html input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .post-navigation a:hover, #image-navigation a:hover, article.post .more-link:hover, article.page .more-link:hover, .paging-navigation a:hover, .woocommerce #page-wrapper .button:hover, .woocommerce a.button:hover, .woocommerce .checkout-button:hover, .woocommerce input.button:hover, #infinite-handle span:hover', 'border-color', $val);
		$builder->add_css('a.button:focus, button:focus, html input[type="button"]:focus, input[type="reset"]:focus, input[type="submit"]:focus, .post-navigation a:focus, #image-navigation a:focus, article.post .more-link:focus, article.page .more-link:focus, .paging-navigation a:focus, .woocommerce #page-wrapper .button:focus, .woocommerce a.button:focus, .woocommerce .checkout-button:focus, .woocommerce input.button:focus, #infinite-handle span:focus', 'border-color', $val);
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_button_text_shadow($builder, $val, $setting){
	if( !$val ) {
		$builder->add_css('a.button, button, html input[type="button"], input[type="reset"], input[type="submit"], .post-navigation a, #image-navigation a, article.post .more-link, article.page .more-link, .paging-navigation a, .woocommerce #page-wrapper .button, .woocommerce a.button, .woocommerce .checkout-button, .woocommerce input.button, #infinite-handle span button', 'text-shadow', 'none');
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_button_shadow($builder, $val, $setting){
	if( !$val ) {
		$builder->add_css('a.button, button, html input[type="button"], input[type="reset"], input[type="submit"], .post-navigation a, #image-navigation a, article.post .more-link, article.page .more-link, .paging-navigation a, .woocommerce #page-wrapper .button, .woocommerce a.button, .woocommerce .checkout-button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, #infinite-handle span', '-webkit-box-shadow', 'none');
		$builder->add_css('a.button, button, html input[type="button"], input[type="reset"], input[type="submit"], .post-navigation a, #image-navigation a, article.post .more-link, article.page .more-link, .paging-navigation a, .woocommerce #page-wrapper .button, .woocommerce a.button, .woocommerce .checkout-button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, #infinite-handle span', '-moz-box-shadow', 'none');
		$builder->add_css('a.button, button, html input[type="button"], input[type="reset"], input[type="submit"], .post-navigation a, #image-navigation a, article.post .more-link, article.page .more-link, .paging-navigation a, .woocommerce #page-wrapper .button, .woocommerce a.button, .woocommerce .checkout-button, .woocommerce input.button, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, #infinite-handle span', 'box-shadow', 'none');
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_button_woo_background($builder, $val, $setting){
	if( $val ) {
		$builder->add_css('.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt', 'background', $val);
		$builder->add_css('.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover', 'background', $val);
		$builder->add_css('.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover', 'opacity', '0.75');
		$builder->add_css('.woocommerce #respond input#submit.alt:focus, .woocommerce a.button.alt:focus, .woocommerce button.button.alt:focus, .woocommerce input.button.alt:focus', 'background', $val);
		$builder->add_css('.woocommerce #respond input#submit.alt:focus, .woocommerce a.button.alt:focus, .woocommerce button.button.alt:focus, .woocommerce input.button.alt:focus', 'opacity', '0.75');
	}
	return $builder;
}
/**
 * @param SiteOrigin_Customizer_CSS_Builder $builder
 * @param mixed $val
 * @param array $setting
 *
 * @return SiteOrigin_Customizer_CSS_Builder
 */
function vantage_customizer_callback_image_layout($builder, $val, $setting){
	if( $val ) {
		if ( $val == 'center' ) {
			$builder->add_css($setting['selector'], 'background-position', 'center');
			$builder->add_css($setting['selector'], 'background-repeat', 'no-repeat');
		}
		else if ( $val == 'tile' ) {
			$builder->add_css($setting['selector'], 'background-repeat', 'repeat');
		}
		else if ( $val == 'cover' ) {
			$builder->add_css($setting['selector'], 'background-size', 'cover');
		}
	}
	return $builder;
}
function vantage_customizer_change_body_class($classes){
	$sidebar_position = get_theme_mod('vantage_sidebar_position');
	if( !empty($sidebar_position) ) {
		$classes[] = 'sidebar-position-' . sanitize_html_class($sidebar_position);
	}
	return $classes;
}
add_filter('body_class', 'vantage_customizer_change_body_class');
