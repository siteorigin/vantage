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

	siteorigin_settings_add_field('logo', 'in_menu_constrain', 'checkbox', __('Constrain Logo Height', 'vantage'), array(
		'label' => __('Yes', 'vantage'),
		'description' => __('When using the "logo in menu" masthead layout, constrain the logo size to fit the menu height.', 'vantage'),
		'conditional' => array(
			'show' => array(
				'layout_masthead' => 'logo-in-menu',
			),
			'hide' => 'else'
		)
	) );

	siteorigin_settings_add_teaser('logo', 'image_retina', __('Retina Logo', 'vantage'), array(
		'choose' => __('Choose Image', 'vantage'),
		'update' => __('Set Logo', 'vantage'),
		'description' => __('A double sized version of your logo for retina displays. Must be used in addition to standard logo.', 'vantage'),
		'teaser-image' => get_template_directory_uri().'/upgrade/teasers/retina-logo.png',
	) );

	siteorigin_settings_add_field('logo', 'header_text', 'text', __('Header Text', 'vantage'), array(
		'description' => __('Text that appears to the right of your logo.', 'vantage')
	) );

	siteorigin_settings_add_field('logo', 'no_widget_overlay', 'checkbox', __('No Widget Overlay', 'vantage'), array(
		'description' => __('If enabled, header widgets wont overlap main logo image.', 'vantage')
	));

	/**
	 * Layout Settings
	 */

	siteorigin_settings_add_field('layout', 'responsive', 'checkbox', __('Responsive Layout', 'vantage'), array(
		'description' => __('Scale your layout for small screen devices.', 'vantage')
	));

	siteorigin_settings_add_field('layout', 'fitvids', 'checkbox', __('Enable FitVids.js', 'vantage'), array(
		'description' => __('Include FitVids.js fluid embedded video layouts.', 'vantage')
	));

	siteorigin_settings_add_field('layout', 'bound', 'select', __('Layout Bound', 'vantage'), array(
		'options' => array(
			'boxed' => __('Boxed', 'vantage'),
			'full' => __('Full Width', 'vantage'),
		),
		'description' => __('Change the width of the bounding box.', 'vantage')
	) );

	siteorigin_settings_add_field('layout', 'masthead', 'select', __('Masthead Layout', 'vantage'), array(
		'options' => siteorigin_settings_template_part_names('parts/masthead', 'Part Name'),
		'description' => __("Change which header area layout you're using.", 'vantage')
	) );

	siteorigin_settings_add_field('layout', 'menu', 'select', __('Masthead Menu', 'vantage'), array(
		'options' => siteorigin_settings_template_part_names('parts/menu', 'Part Name'),
		'description' => __("Choose how the masthead menu is displayed.", 'vantage')
	) );

	siteorigin_settings_add_field('layout', 'footer', 'select', __('Footer Layout', 'vantage'), array(
		'options' => siteorigin_settings_template_part_names('parts/footer', 'Part Name'),
		'description' => __("Change which footer area layout you're using.", 'vantage')
	) );

	/**
	 * Navigation settings
	 */

	siteorigin_settings_add_teaser('navigation', 'responsive_menu', __('Responsive Menu', 'vantage'), array(
		'description' => __('Use a special responsive menu for small screen devices.', 'vantage'),
		'teaser-image' => get_template_directory_uri().'/upgrade/teasers/mobile-nav.png',
	));

	siteorigin_settings_add_teaser('navigation', 'responsive_menu_text', __('Responsive Menu Text', 'vantage'), array(
		'description' => __('The button used for the responsive menu.', 'vantage')
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

	siteorigin_settings_add_field( 'navigation', 'post_nav', 'checkbox', __('Post Navigation', 'vantage'), array(
		'description' => __('Display next/previous post navigation.', 'vantage')
	) );

	siteorigin_settings_add_field( 'navigation', 'home_icon', 'checkbox', __('Home Page Icon', 'vantage'), array(
		'description' => __('Display home icon for home page menu links.', 'vantage')
	) );

	siteorigin_settings_add_field('navigation', 'mobile_navigation', 'checkbox', __('Mobile Navigation', 'vantage'), array(
		'description' => __('Enables Sticky Menu and Scroll To Top for mobile devices.', 'vantage')
	));

	if( function_exists('yoast_breadcrumb') ) {
		siteorigin_settings_add_field('navigation', 'yoast_breadcrumbs', 'checkbox', __('Yoast Breadcrumbs', 'vantage'), array(
			'description' => __('Display Yoast SEO breadcrumbs if you have it installed.', 'vantage')
		) );
	}

	/**
	 * Home Page
	 */

	siteorigin_settings_add_field('home', 'slider', 'select', __('Home Page Slider', 'vantage'), array(
		'options' => siteorigin_metaslider_get_options(true),
		'description' => sprintf(
			__('This theme supports <a href="%s" target="_blank">Meta Slider</a>. <a href="%s">Install it</a> for free to create beautiful responsive sliders - <a href="%s" target="_blank">More Info</a>', 'vantage'),
			'https://siteorigin.com/metaslider/',
			siteorigin_metaslider_install_link(),
			'https://siteorigin.com/vantage-documentation/slider/'
		)
	));

	siteorigin_settings_add_field('home', 'slider_stretch', 'checkbox', __('Stretch Home Slider', 'vantage'), array(
		'label' => __('Stretch', 'vantage'),
		'description' => __('Stretch the home page slider to the width of the screen if using the full width layout.', 'vantage'),
	) );

	/**
	 * Blog Settings
	 */

	siteorigin_settings_add_field('blog', 'archive_layout', 'select', __('Blog Archive Layout', 'vantage'), array(
		'options' => vantage_blog_layout_options(),
		'description' => __('Show the post author in blog archive pages.', 'vantage')
	) );

	siteorigin_settings_add_field('blog', 'archive_content', 'select', __('Post Content', 'vantage'), array(
		'options' => array(
			'full' => __('Full Post', 'vantage'),
			'excerpt' => __('Post Excerpt', 'vantage'),
		),
		'description' => __('Choose how to display posts on post archive when using default blog layout.', 'vantage')
	));

	siteorigin_settings_add_field('blog', 'post_metadata', 'checkbox', __('Post Metadata', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post metadata in blog archive pages.', 'vantage')
	));

	siteorigin_settings_add_field('blog', 'post_author', 'checkbox', __('Post Author', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post author in blog archive pages.', 'vantage')
	));

	siteorigin_settings_add_field('blog', 'post_date', 'checkbox', __('Post Date', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post date.', 'vantage')
	));

	siteorigin_settings_add_field('blog', 'featured_image', 'checkbox', __('Featured Image', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the featured image on a post single page.', 'vantage')
	) );

	siteorigin_settings_add_field('blog', 'featured_image_type', 'select', __('Featured Image Type', 'vantage'), array(
		'options' => array(
			'large' => __('Large', 'vantage'),
			'icon' => __('Small Icon', 'vantage'),
		),
		'description' => __('Size of the featured image in the blog post archives.', 'vantage')
	) );

	siteorigin_settings_add_field('blog', 'author_box', 'checkbox', __('Author Box', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show an author box below each blog post.', 'vantage')
	) );

	/**
	 * Social Settings
	 */

	siteorigin_settings_add_teaser('social', 'ajax_comments', __('Ajax Comments', 'vantage'), array(
		'description' => __('Keep your conversations flowing with ajax comments.', 'vantage')
	));

	siteorigin_settings_add_teaser('social', 'share_post', __('Post Sharing', 'vantage'), array(
		'description' => __('Show icons to share your posts on Facebook, Twitter and Google+.', 'vantage'),
		'teaser-image' => get_template_directory_uri().'/upgrade/teasers/share.png',
	));

	siteorigin_settings_add_teaser('social', 'twitter', __('Twitter Handle', 'vantage'), array(
		'description' => __('This handle will be recommended after a user shares one of your posts.', 'vantage'),
		'teaser-image' => get_template_directory_uri().'/upgrade/teasers/share-rec.png',
	));

	/**
	 * General Settings
	 */

	siteorigin_settings_add_field( 'general', 'site_info_text', 'text', __( 'Site Information Text', 'vantage' ), array(
		'description' => __( "Text displayed in your footer. {site-title}, {copyright} and {year} will be replaced with your website title, a copyright symbol and the current year.", 'vantage' )
	) );

	siteorigin_settings_add_teaser('general', 'adaptive_images', __('Mobile Adaptive Images', 'vantage'), array(
		'description' => __('Rescale images to the most appropriate size for mobile devices.', 'vantage'),
		// 'teaser-image' => get_template_directory_uri().'/upgrade/teasers/share-rec.png',
	));

	siteorigin_settings_add_field('general', 'js_enqueue_footer', 'checkbox', __('Enqueue JavaScript in Footer', 'vantage'), array(
		'description' => __('Enqueue JavaScript files in the footer, if possible.', 'vantage'),
	));

}
add_action('siteorigin_settings_init', 'vantage_theme_settings');

/**
 * Setup theme default settings.
 * 
 * @param $defaults
 * @return mixed
 * @since vantage 1.0
 */
function vantage_theme_setting_defaults($defaults){
	$defaults['logo_image'] = false;
	$defaults['logo_in_menu_constrain'] = true;
	$defaults['logo_image_retina'] = false;
	$defaults['logo_header_text'] = __('Call me! Maybe?', 'vantage');
	$defaults['logo_no_widget_overlay'] = false;

	$defaults['layout_responsive'] = true;
	$defaults['layout_fitvids'] = true;
	$defaults['layout_bound'] = 'full';
	$defaults['layout_masthead'] = '';
	$defaults['layout_footer'] = '';

	$defaults['navigation_responsive_menu'] = true;
	$defaults['navigation_responsive_menu_text'] = '';
	$defaults['navigation_use_sticky_menu'] = true;
	$defaults['navigation_mobile_navigation'] = false;
	$defaults['navigation_menu_search'] = true;
	$defaults['navigation_display_scroll_to_top'] = true;
	$defaults['navigation_post_nav'] = true;
	$defaults['navigation_home_icon'] = false;
	$defaults['navigation_yoast_breadcrumbs'] = true;

	$defaults['home_slider'] = 'demo';
	$defaults['home_slider_stretch'] = true;

	$defaults['blog_archive_layout'] = 'blog';
	$defaults['blog_archive_content'] = 'full';
	$defaults['blog_post_metadata'] = true;
	$defaults['blog_post_author'] = true;
	$defaults['blog_post_date'] = true;
	$defaults['blog_featured_image'] = true;
	$defaults['blog_featured_image_type'] = 'large';
	$defaults['blog_author_box'] = false;

	$defaults['social_ajax_comments'] = true;
	$defaults['social_share_post'] = true;
	$defaults['social_twitter'] = '';

	$defaults['general_site_info_text'] = '';
	$defaults['general_adaptive_images'] = false;
	$defaults['general_js_enqueue_footer'] = false;

	return $defaults;
}
add_filter('siteorigin_theme_default_settings', 'vantage_theme_setting_defaults');

function vantage_blog_layout_options(){
	$layouts = array();
	foreach( glob(get_template_directory().'/loops/loop-*.php') as $template ) {
		$headers = get_file_data( $template, array(
			'loop_name' => 'Loop Name',
		) );

		preg_match('/loop\-(.*?)\.php/', basename($template), $matches);
		if(!empty($matches[1])) {
			$layouts[$matches[1]] = $headers['loop_name'];
		}
	}

	static $exclude = array(
		'carousel', 'slider'
	);

	foreach($exclude as $e) unset($layouts[$e]);
	return $layouts;
}

function vantage_feature_suggestion_url($url){
	return 'http://sorig.in/vantage-suggestions';
}
add_filter('siteorigin_settings_suggest_features_url', 'vantage_feature_suggestion_url');

function vantage_siteorigin_settings_page_icon($icon){
	return get_template_directory_uri().'/images/settings-icon.png';
}
add_filter('siteorigin_settings_page_icon', 'vantage_siteorigin_settings_page_icon');

function vantage_siteorigin_settings_home_slider_update_post_meta( $new_value, $old_value ) {
	//Update home slider post meta.
	$home_id = get_option( 'page_on_front' );
	if ( $home_id != 0 ) {
		if ( $new_value['home_slider'] != $old_value['home_slider'] ) {
			update_post_meta($home_id, 'vantage_metaslider_slider', $new_value['home_slider'] );
		}
		if ( $new_value['home_slider_stretch'] != $old_value['home_slider_stretch'] ) {
			update_post_meta($home_id, 'vantage_metaslider_slider_stretch', $new_value['home_slider_stretch']);
		}
	}
	return $new_value;
}
add_filter( 'pre_update_option_vantage_theme_settings', 'vantage_siteorigin_settings_home_slider_update_post_meta', 10, 2 );