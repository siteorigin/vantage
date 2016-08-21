<?php
/**
 * Configure theme settings.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

if( !function_exists('vantage_theme_settings') ) :
/**
 * Setup theme settings.
 *
 * @since vantage 1.0
 */
function vantage_theme_settings(){
	$settings = SiteOrigin_Settings::single();

	$settings->add_section( 'logo', __('Logo', 'vantage' ) );
	$settings->add_section( 'layout', __('Layout', 'vantage' ) );
	$settings->add_section( 'home', __('Home', 'vantage' ) );
	$settings->add_section( 'navigation', __('Navigation', 'vantage' ) );
	$settings->add_section( 'blog', __('Blog', 'vantage' ) );
	$settings->add_section( 'social', __('Social', 'vantage' ) );
	$settings->add_section( 'general', __('General', 'vantage' ) );

	/**
	 * Logo Settings
	 */

	$settings->add_field('logo', 'image', 'media', __('Logo Image', 'vantage'), array(
		'choose' => __('Choose Image', 'vantage'),
		'update' => __('Set Logo', 'vantage'),
		'description' => __('Your own custom logo.', 'vantage')
	) );

	$settings->add_field('logo', 'in_menu_constrain', 'checkbox', __('Constrain Logo Height', 'vantage'), array(
		'label' => __('Yes', 'vantage'),
		'description' => __('When using the "logo in menu" masthead layout, constrain the logo size to fit the menu height.', 'vantage'),
	) );

	$settings->add_field('logo', 'with_text', 'checkbox', __('Display site title alongside logo', 'vantage'), array(
		'description' => __("Only applicable if a Logo Image has been set.", 'vantage')
	));

	$settings->add_field('logo', 'image_retina', 'media', __('Retina Logo', 'vantage'), array(
		'choose' => __('Choose Image', 'vantage'),
		'update' => __('Set Logo', 'vantage'),
		'description' => __('A double sized version of your logo for retina displays. Must be used in addition to standard logo.', 'vantage'),
	) );

	$settings->add_field('logo', 'header_text', 'text', __('Header Text', 'vantage'), array(
		'description' => __('Text that appears to the right of your logo. It will be hidden if widgets are placed in the header.', 'vantage'),
		'sanitize_callback' => 'wp_kses_post'
	) );

	$settings->add_field('logo', 'no_widget_overlay', 'checkbox', __('No Widget Overlay', 'vantage'), array(
		'description' => __("If enabled, header widgets won't overlap main logo image.", 'vantage')
	));

	/**
	 * Layout Settings
	 */

	$settings->add_field('layout', 'responsive', 'checkbox', __('Responsive Layout', 'vantage'), array(
		'description' => __('Scale your layout for small screen devices.', 'vantage')
	));

	$settings->add_field('layout', 'fitvids', 'checkbox', __('Enable FitVids.js', 'vantage'), array(
		'description' => __('Include FitVids.js fluid embedded video layouts.', 'vantage')
	));

	$settings->add_field('layout', 'bound', 'select', __('Layout Bound', 'vantage'), array(
		'options' => array(
			'boxed' => __('Boxed', 'vantage'),
			'full' => __('Full Width', 'vantage'),
		),
		'description' => __('Change the width of the bounding box.', 'vantage')
	) );

	$settings->add_field('layout', 'masthead', 'select', __('Masthead Layout', 'vantage'), array(
		'options' => $settings->template_part_names('parts/masthead', 'Part Name'),
		'description' => __("Change which header area layout you're using.", 'vantage')
	) );

	$settings->add_field('layout', 'menu', 'select', __('Masthead Menu', 'vantage'), array(
		'options' => $settings->template_part_names('parts/menu', 'Part Name'),
		'description' => __("Choose how the masthead menu is displayed.", 'vantage')
	) );

	$settings->add_field('layout', 'footer', 'select', __('Footer Layout', 'vantage'), array(
		'options' => $settings->template_part_names('parts/footer', 'Part Name'),
		'description' => __("Change which footer area layout you're using.", 'vantage')
	) );

	$settings->add_field('layout', 'force_panels_full', 'checkbox', __('Force Page Builder Styles Full Width', 'vantage'), array(
		'description' => __('Force Page Builder rows with styles to be full width. Only necessary for legacy reasons.', 'vantage')
	));

	/**
	 * Navigation settings
	 */

	$settings->add_field('navigation', 'responsive_menu', 'checkbox', __('Mobile Menu', 'vantage'), array(
		'description' => __('Use a special mobile menu for small screen devices.', 'vantage'),
	));

	$settings->add_field('navigation', 'responsive_menu_collapse', 'number', __('Mobile Menu Collapse', 'vantage'), array(
		'description' => __('The resolution when the menu collapses into a mobile navigation menu. Value is in pixels.', 'vantage')
	) );

	$settings->add_field('navigation', 'responsive_menu_text', 'text', __('Mobile Menu Text', 'vantage'), array(
		'description' => __('The button used for the mobile menu.', 'vantage')
	));

	$settings->add_field('navigation', 'responsive_menu_search', 'checkbox', __('Mobile Menu Search', 'vantage'), array(
		'description' => __('Enable search in the mobile menu.', 'vantage')
	));

	$settings->add_field('navigation', 'use_sticky_menu', 'checkbox', __('Sticky Menu', 'vantage'), array(
		'description' => __('Sticks the menu to the top of the screen when a user scrolls down.', 'vantage')
	));

	$settings->add_field('navigation', 'menu_search', 'checkbox', __('Search in Menu', 'vantage'), array(
		'description' => __('Display a search in the main menu.', 'vantage')
	));

	$settings->add_field('navigation', 'display_scroll_to_top', 'checkbox', __('Display Scroll To Top', 'vantage'), array(
		'description' => __('Display a scroll-to-top button when a user scrolls down.', 'vantage')
	));

	$settings->add_field( 'navigation', 'post_nav', 'checkbox', __('Post Navigation', 'vantage'), array(
		'description' => __('Display next/previous post navigation.', 'vantage')
	) );

	$settings->add_field( 'navigation', 'home_icon', 'checkbox', __('Home Page Icon', 'vantage'), array(
		'description' => __('Display home icon for home page menu links.', 'vantage')
	) );

	$settings->add_field('navigation', 'mobile_navigation', 'checkbox', __('Mobile Navigation', 'vantage'), array(
		'description' => __('Enables Sticky Menu and Scroll To Top for mobile devices.', 'vantage')
	));

	if( function_exists('yoast_breadcrumb') || function_exists('bcn_display') ) {
		$settings->add_field('navigation', 'yoast_breadcrumbs', 'checkbox', __('Breadcrumbs', 'vantage'), array(
			'description' => __('Display breadcrumbs if you have Yoast SEO or Breadcrumb NavXT installed.', 'vantage')
		) );
	}

	/**
	 * Home Page
	 */

	$settings->add_field('home', 'slider', 'select', __('Home Page Slider', 'vantage'), array(
		'options' => siteorigin_metaslider_get_options(true),
		'description' => sprintf(
			__('This theme supports <a href="%s" target="_blank">Meta Slider</a>. <a href="%s">Install it</a> for free to create beautiful responsive sliders - <a href="%s" target="_blank">More Info</a>', 'vantage'),
			'https://siteorigin.com/metaslider/',
			siteorigin_metaslider_install_link(),
			'https://siteorigin.com/vantage-documentation/slider/'
		)
	));

	$settings->add_field('home', 'slider_stretch', 'checkbox', __('Stretch Home Slider', 'vantage'), array(
		'label' => __('Stretch', 'vantage'),
		'description' => __('Stretch the home page slider to the width of the screen if using the full width layout.', 'vantage'),
	) );

	/**
	 * Blog Settings
	 */

	$settings->add_field('blog', 'archive_layout', 'select', __('Blog Archive Layout', 'vantage'), array(
		'options' => vantage_blog_layout_options(),
		'description' => __('Choose the layout to be used on blog and archive pages.', 'vantage')
	) );

	$settings->add_field('blog', 'archive_content', 'select', __('Post Content', 'vantage'), array(
		'options' => array(
			'full' => __('Full Post', 'vantage'),
			'excerpt' => __('Post Excerpt', 'vantage'),
		),
		'description' => __('Choose how to display posts on post archive when using default blog layout.', 'vantage'),
	));

	$settings->add_field('blog', 'featured_image_type', 'select', __('Featured Image Type', 'vantage'), array(
		'options' => array(
			'large' => __('Large', 'vantage'),
			'icon' => __('Small Icon', 'vantage'),
		),
		'description' => __('Size of the featured image in the blog post archives when using default blog layout.', 'vantage')
	) );

	$settings->add_field('blog', 'featured_image', 'checkbox', __('Featured Image', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the featured image on a post single page.', 'vantage')
	) );

	$settings->add_field('blog', 'post_metadata', 'checkbox', __('Post Metadata', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post metadata under the post title.', 'vantage')
	));

	$settings->add_field('blog', 'post_date', 'checkbox', __('Post Date', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post date under the post title.', 'vantage')
	));

	$settings->add_field('blog', 'post_author', 'checkbox', __('Post Author', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post author under the post title.', 'vantage')
	));

	$settings->add_field('blog', 'post_comment_count', 'checkbox', __('Post Comment Count', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the number of comments under the post title.', 'vantage')
	));

	$settings->add_field('blog', 'post_categories', 'checkbox', __('Post Categories', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post categories below the single post.', 'vantage')
	));

	$settings->add_field('blog', 'post_tags', 'checkbox', __('Post Tags', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show the post tags below the single post.', 'vantage')
	));

	$settings->add_field('blog', 'author_box', 'checkbox', __('Author Box', 'vantage'), array(
		'label' => __('Display', 'vantage'),
		'description' => __('Show an author box below each blog post.', 'vantage')
	) );

	$settings->add_field('blog', 'comment_author', 'text', __("Post Author's Comments", 'vantage'), array(
		'description' => __("Text displayed as a label next to the post author's comments.", 'vantage'),
		'sanitize_callback' => 'wp_kses_post',
	));

	$settings->add_field('blog', 'read_more', 'text', __('Read More Text', 'vantage'), array(
		'description' => __('The link displayed when post content is split using the "more" quicktag.', 'vantage')
	));

	/**
	 * Social Settings
	 */

	$settings->add_teaser('social', 'ajax_comments', 'checkbox', __('Ajax Comments', 'vantage'), array(
		'description' => __('Keep your conversations flowing with ajax comments.', 'vantage'),
		'featured' => 'theme/ajax-comments',
	));

	/**
	 * General Settings
	 */

	$settings->add_field( 'general', 'site_info_text', 'text', __( 'Site Information Text', 'vantage' ), array(
		'description' => __( "Text displayed in your footer. {site-title}, {copyright} and {year} will be replaced with your website title, a copyright symbol and the current year.", 'vantage' ),
		'sanitize_callback' => 'wp_kses_post'
	) );

	$settings->add_teaser( 'general', 'attribution', 'checkbox', __( 'SiteOrigin Attribution', 'vantage' ), array(
		'description' => __( "Add or remove a link to SiteOrigin in your footer.", 'vantage' ),
		'featured' => 'theme/no-attribution',
	) );

	$settings->add_field('general', 'js_enqueue_footer', 'checkbox', __('Enqueue JavaScript in Footer', 'vantage'), array(
		'description' => __('Enqueue JavaScript files in the footer, if possible.', 'vantage'),
	));

}
endif;
add_action('siteorigin_settings_init', 'vantage_theme_settings');

if( !function_exists('vantage_theme_setting_defaults') ) :
/**
 * Setup theme default settings.
 *
 * @param $defaults
 * @return mixed
 * @since vantage 1.0
 */
function vantage_theme_setting_defaults($defaults){
	$defaults['logo_image'] = false;
	$defaults['logo_image_retina'] = false;
	$defaults['logo_in_menu_constrain'] = true;
	$defaults['logo_with_text'] = false;
	$defaults['logo_header_text'] = __('Call me! Maybe?', 'vantage');
	$defaults['logo_no_widget_overlay'] = false;

	$defaults['layout_responsive'] = true;
	$defaults['layout_fitvids'] = true;
	$defaults['layout_bound'] = 'full';
	$defaults['layout_masthead'] = '';
	$defaults['layout_footer'] = '';
	$defaults['layout_force_panels_full'] = true;

	$defaults['navigation_responsive_menu'] = true;
	$defaults['navigation_responsive_menu_collapse'] = 480;
	$defaults['navigation_responsive_menu_text'] = '';
	$defaults['navigation_responsive_menu_search'] = true;

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
	$defaults['blog_featured_image'] = true;
	$defaults['blog_featured_image_type'] = 'large';
	$defaults['blog_post_metadata'] = true;
	$defaults['blog_post_date'] = true;
	$defaults['blog_post_author'] = true;
	$defaults['blog_post_comment_count'] = false;
	$defaults['blog_post_categories'] = true;
	$defaults['blog_post_tags'] = true;
	$defaults['blog_author_box'] = false;
	$defaults['blog_comment_author'] = '';
	$defaults['blog_read_more'] = __('Continue reading', 'vantage');

	$defaults['social_ajax_comments'] = true;

	$defaults['general_site_info_text'] = '';
	$defaults['general_attribution'] = true;
	$defaults['general_js_enqueue_footer'] = false;

	return $defaults;
}
endif;
add_filter('siteorigin_settings_defaults', 'vantage_theme_setting_defaults');

if( !function_exists('vantage_blog_layout_options') ) :
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
endif;

if( !function_exists('vantage_siteorigin_settings_home_slider_update_post_meta') ) :
function vantage_siteorigin_settings_home_slider_update_post_meta( $new_value, $old_value ) {

	if( !isset( $new_value['home_slider'] ) || ! isset( $new_value['home_slider_stretch'] ) ) return $new_value;

	//Update home slider post meta.
	$home_id = get_option( 'page_on_front' );
	if ( $home_id != 0 ) {
		update_post_meta( $home_id, 'vantage_metaslider_slider', $new_value['home_slider'] );
		update_post_meta( $home_id, 'vantage_metaslider_slider_stretch', $new_value['home_slider_stretch'] );
	}
	return $new_value;
}
endif;
add_filter( 'pre_update_option_theme_mods_vantage', 'vantage_siteorigin_settings_home_slider_update_post_meta', 10, 2 );

if( !function_exists('vantage_siteorigin_settings_localize') ) :
function vantage_siteorigin_settings_localize( $loc ){
	$loc = array(
		'section_title' => __('Theme Settings', 'vantage'),
		'section_description' => __('Settings for your theme', 'vantage'),
		'premium_only' =>  __('Premium Only', 'vantage'),
		'premium_url' => '#',

		// For the controls
		'variant' =>  __('Variant', 'vantage'),
		'subset' =>  __('Subset', 'vantage'),

		// For the premium upgrade modal
		'modal_title' => __('Vantage Premium Upgrade', 'vantage'),
		'close' => __('Close', 'vantage'),

		// For the settings metabox
		'meta_box'            => __( 'Page settings', 'vantage' ),

		// For archives section
		'page_section_title' => __( 'Page Template Settings', 'vantage' ),
		'page_section_description' => __( 'Change layouts for various pages on your site.', 'vantage' ),

		// For all the different temples and template types
		'template_home' => __( 'Blog Page', 'vantage' ),
		'template_search' => __( 'Search Results', 'vantage' ),
		'template_date' => __( 'Date Archives', 'vantage' ),
		'template_404' => __( 'Not Found', 'vantage' ),
		'template_author' => __( 'Author Archives', 'vantage' ),
		'templates_post_type' => __( 'Type', 'vantage' ),
		'templates_taxonomy' => __( 'Taxonomy', 'vantage' ),
	);

	return $loc;
}
endif;
add_filter( 'siteorigin_settings_localization', 'vantage_siteorigin_settings_localize' );


if ( ! function_exists( 'vantage_page_settings' ) ) :
/**
 * Setup Page Settings for Vantage
 */
function vantage_page_settings( $settings, $type, $id ){

	$settings['layout'] = array(
		'type'    => 'select',
		'label'   => __( 'Page Layout', 'vantage' ),
		'options' => array(
			'default'            => __( 'Default', 'vantage' ),
			'no-sidebar'         => __( 'No Sidebar', 'vantage' ),
			'full-width'         => __( 'Full Width', 'vantage' ),
			'full-width-sidebar' => __( 'Full Width, With Sidebar', 'vantage' ),
		),
	);

	if( $type == 'post' ) $post = get_post( $id );
	if( ! empty( $post ) && $post->post_type == 'page' ) {
		$settings['featured_image'] = array(
			'type'           => 'checkbox',
			'label'          => __( 'Page Featured Image', 'vantage' ),
			'checkbox_label' => __( 'display', 'vantage' ),
			'description'    => __( 'Display the page featured image on this page.', 'vantage' )
		);
	}

	$settings['page_title'] = array(
		'type'           => 'checkbox',
		'label'          => __( 'Page Title', 'vantage' ),
		'checkbox_label' => __( 'display', 'vantage' ),
		'description'    => __( 'Display the page title on this page.', 'vantage' )
	);

	$settings['masthead_margin'] = array(
		'type'           => 'checkbox',
		'label'          => __( 'Masthead Bottom Margin', 'vantage' ),
		'checkbox_label' => __( 'enable', 'vantage' ),
		'description'    => __( 'Include the margin below the masthead (top area) of your site.', 'vantage' )
	);

	$settings['footer_margin'] = array(
		'type'           => 'checkbox',
		'label'          => __( 'Footer Top Margin', 'vantage' ),
		'checkbox_label' => __( 'enable', 'vantage' ),
		'description'    => __( 'Include the margin above your footer.', 'vantage' )
	);

	$settings['hide_masthead'] = array(
		'type'           => 'checkbox',
		'label'          => __( 'Hide Masthead', 'vantage' ),
		'checkbox_label' => __( 'hide', 'vantage' ),
		'description'    => __( 'Hide the masthead on this page.', 'vantage' )
	);

	$settings['hide_footer_widgets'] = array(
		'type'           => 'checkbox',
		'label'          => __( 'Hide Footer Widgets', 'vantage' ),
		'checkbox_label' => __( 'hide', 'vantage' ),
		'description'    => __( 'Hide the footer widgets on this page.', 'vantage' )
	);

	return $settings;
}
endif;
add_filter( 'siteorigin_page_settings', 'vantage_page_settings', 10, 3 );

if ( ! function_exists( 'vantage_setup_page_setting_defaults' ) ) :
/**
 * Add the default Page Settings
 */
function vantage_setup_page_setting_defaults( $defaults, $type, $id ){
	// All the basic default settings
	$defaults['layout']              = 'default';
	$defaults['page_title']          = true;
	$defaults['masthead_margin']     = true;
	$defaults['footer_margin']       = true;
	$defaults['hide_masthead']       = false;
	$defaults['hide_footer_widgets'] = false;

	// Defaults for page only settings
	if( $type == 'post' ) $post = get_post( $id );
	if( ! empty( $post ) && $post->post_type == 'page' ) {
		$defaults['featured_image'] = false;
	}

	// Specific default settings for different types
	if( $type == 'template' && $id == 'home' ) {
		$defaults['page_title'] = false;
	}

	return $defaults;
}
endif;
add_filter( 'siteorigin_page_settings_defaults', 'vantage_setup_page_setting_defaults', 10, 3 );

function vantage_page_settings_message( $post ){
	if( $post->post_type == 'page' ) {
		?>
		<div class="so-page-settings-message" style="background-color: #f3f3f3; padding: 10px; margin-top: 12px; border: 1px solid #d0d0d0">
			<?php _e( 'To use these page settings, please use the <strong>Default</strong> template selected under <strong>Page Attributes</strong>', 'vantage' ) ?>
		</div>
		<?php
	}
}
add_action( 'siteorigin_settings_before_page_settings_meta_box', 'vantage_page_settings_message' );

if ( ! function_exists( 'vantage_page_settings_panels_defaults' ) ) :
/**
 * Change the default page settings for the home page.
 *
 * @param $settings
 *
 * @return mixed
 */
function vantage_page_settings_panels_defaults( $settings ){
	$settings['layout']     = 'no-sidebar';
	$settings['page_title'] = false;

	return $settings;
}
endif;
add_filter('siteorigin_page_settings_panels_home_defaults', 'vantage_page_settings_panels_defaults');

function vantage_about_page_sections( $about ){
	$about['title_image'] = get_template_directory_uri() . '/admin/about/vantage-logo.png';
	$about['title_image_2x'] = get_template_directory_uri() . '/admin/about/vantage-logo-2x.png';

	$about['documentation_url'] = 'https://siteorigin.com/vantage-documentation/';

	$about[ 'video_thumbnail' ] = array(
		get_template_directory_uri() . '/admin/about/stills/still-1.jpg',
		get_template_directory_uri() . '/admin/about/stills/still-2.jpg',
		get_template_directory_uri() . '/admin/about/stills/still-3.jpg'
	);

	$about['description'] = __( 'Vantage is a flexible multipurpose theme. Its strength lies in its tight integration with some powerful plugins like Page Builder for responsive page layouts, Meta Slider for big beautiful sliders and WooCommerce to help you sell online. Vantage is fully responsive and retina ready. Use it to start a business site, portfolio or online store.', 'vantage' );

	$about[ 'review' ] = true;

	$about[ 'sections' ] = array(
		'free',
		'support',
		'mature',
		'page-builder',
		'github',
	);

	return $about;
}
add_filter( 'siteorigin_about_page', 'vantage_about_page_sections' );
