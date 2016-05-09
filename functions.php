<?php
/**
 * vantage functions and definitions
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

define('SITEORIGIN_THEME_VERSION', 'dev');
define('SITEORIGIN_THEME_JS_PREFIX', '');

// Load the new settings framework
include get_template_directory() . '/inc/settings/settings.php';
include get_template_directory() . '/inc/settings/page-settings.php';
include get_template_directory() . '/inc/metaslider/metaslider.php';
include get_template_directory() . '/inc/plugin-activation/plugin-activation.php';

// Load the theme specific files
include get_template_directory() . '/inc/panels.php';
include get_template_directory() . '/inc/settings.php';
include get_template_directory() . '/inc/extras.php';
include get_template_directory() . '/inc/template-tags.php';
include get_template_directory() . '/inc/gallery.php';
include get_template_directory() . '/inc/metaslider.php';
include get_template_directory() . '/inc/widgets.php';
include get_template_directory() . '/inc/menu.php';
include get_template_directory() . '/inc/seo.php';
include get_template_directory() . '/inc/customizer.php';

include get_template_directory() . '/fontawesome/icon-migration.php';


if ( ! function_exists( 'vantage_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since vantage 1.0
 */
function vantage_setup() {

	// Make the theme translatable
	load_theme_textdomain( 'vantage', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails
	add_theme_support( 'post-thumbnails' );

	add_theme_support( 'siteorigin-panels', array(
		'home-page' => true,
		'margin-bottom' => 35,
		'home-page-default' => 'default-home',
		'home-demo-template' => 'home-panels.php',
		'responsive' => siteorigin_setting( 'layout_responsive' ),
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'vantage' ),
	) );

	// Enable support for Post Formats
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	// We support WooCommerce
	add_theme_support('woocommerce');

	set_post_thumbnail_size(720, 380, true );
	add_image_size( 'vantage-thumbnail-no-sidebar', 1080, 380, true );
	add_image_size( 'vantage-slide', 960, 480, true );
	add_image_size( 'vantage-carousel', 272, 182, true );
	add_image_size( 'vantage-grid-loop', 436, 272, true );

	add_theme_support( 'site-logo', array(
		'size' => 'full',
	) );

	if( !defined('SITEORIGIN_PANELS_VERSION') ){
		// Only include panels lite if the panels plugin doesn't exist
		include get_template_directory() . '/inc/panels-lite/panels-lite.php';
	}

	add_theme_support('siteorigin-premium-teaser', array(
		'customizer' => true,
		'settings' => true,
	));

	global $content_width, $vantage_site_width;
	if ( ! isset( $content_width ) ) $content_width = 720; /* pixels */

	if ( ! isset( $vantage_site_width ) ) {
		$vantage_site_width = siteorigin_setting('layout_bound') == 'full' ? 1080 : 1010;
	}

	$container = 'content';
	$render_function = '';
	$wrapper = true;
	// The posts_per_page setting only works when type is 'scroll'.
	// When type is set to 'click' either explicitly or automatically,
	// due to there being footer widgets, it uses the "Blog pages show at most X posts" setting
	// under Settings > Reading instead. :(
	// https://wordpress.org/support/topic/posts_per_page-not-having-any-effect
	$posts_per_page = 7;
	if ( siteorigin_setting( 'blog_archive_layout' ) == 'circleicon' ) {
		$container = 'vantage-circleicon-loop';
		$render_function = 'vantage_infinite_scroll_render';
		$wrapper = false;
		$posts_per_page = 6;
	}
	else if ( siteorigin_setting( 'blog_archive_layout' ) == 'grid' ) {
		$container = 'vantage-grid-loop';
		$render_function = 'vantage_infinite_scroll_render';
		$wrapper = false;
		$posts_per_page = 8;
	}

	add_filter( 'infinite_scroll_settings', 'vantage_infinite_scroll_settings' );

	add_theme_support( 'infinite-scroll', array(
		'container' => $container,
		'footer' => 'page',
		'render' => $render_function,
		'wrapper' => $wrapper,
		'posts_per_page' => $posts_per_page,
		'type' => 'click',
		// 'footer_widgets' => 'sidebar-footer',
	) );

	if( siteorigin_setting( 'navigation_responsive_menu' ) ) {
		include get_template_directory() . '/inc/mobilenav/mobilenav.php';
	}

	// We'll use archive settings
	add_theme_support( 'siteorigin-template-settings' );
}
endif; // vantage_setup
add_action( 'after_setup_theme', 'vantage_setup' );

if ( ! function_exists( 'vantage_premium_setup' ) ) :
/**
 * Add support for premium theme components
 */
function vantage_premium_setup(){

	// This theme supports the no attribution addon
	add_theme_support( 'siteorigin-premium-no-attribution', array(
		'filter'  => 'vantage_footer_attribution',
		'enabled' => siteorigin_setting( 'general_attribution' ),
		'siteorigin_setting' => 'general_attribution'
	) );

	// This theme supports the ajax comments addon
	add_theme_support( 'siteorigin-premium-ajax-comments', array(
		'enabled' => siteorigin_setting( 'social_ajax_comments' ),
		'siteorigin_setting' => 'social_ajax_comments'
	) );
}
endif;
add_action( 'after_setup_theme', 'vantage_premium_setup' );

function vantage_siteorigin_css_snippets_paths( $paths ){
	$paths[] = get_template_directory() . '/snippets/';
	return $paths;
}
add_filter( 'siteorigin_css_snippet_paths', 'vantage_siteorigin_css_snippets_paths' );

if( !function_exists( 'vantage_infinite_scroll_settings' ) ) :
// Override Jetpack Infinite Scroll default behaviour of ignoring explicit posts_per_page setting when type is 'click'.
function vantage_infinite_scroll_settings( $settings ) {
	if ( $settings['type'] == 'click' ) {
		if( siteorigin_setting( 'blog_archive_layout' ) == 'circleicon' ) {
			$settings['posts_per_page'] = 6;
		}
		else if ( siteorigin_setting( 'blog_archive_layout' ) == 'grid' ) {
			$settings['posts_per_page'] = 8;
		}
	}
	return $settings;
}
endif;

if ( ! function_exists( 'vantage_infinite_scroll_render' ) ) :
function vantage_infinite_scroll_render() {
	ob_start();
	get_template_part( 'loops/loop', siteorigin_setting( 'blog_archive_layout' ) );
	$var = ob_get_clean();
	// Strip leading and trailing whitespace.
	$var = trim( $var );
	// Remove the opening and closing div tags for subsequent pages of posts for correct circleicon and grid layouts.
	$var = preg_replace( '/^<div.+>/', '', $var );
	$var = preg_replace( '/<\/div>$/', '', $var );
	echo $var;
}
endif;

if ( ! function_exists( 'vantage_is_woocommerce_active' ) ) :
/**
 * Check that WooCommerce is active
 *
 * @return bool
 */
function vantage_is_woocommerce_active() {
	return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );
}
endif;

if( !function_exists('vantage_register_custom_background') ) :
/**
 * Setup the WordPress core custom background feature.
 *
 * @since vantage 1.0
 */
function vantage_register_custom_background() {

	if(siteorigin_setting('layout_bound') == 'boxed') {
		$args = array(
			'default-color' => 'e8e8e8',
			'default-image' => '',
		);

		$args = apply_filters( 'vantage_custom_background_args', $args );
		add_theme_support( 'custom-background', $args );
	}

}
endif;
add_action( 'after_setup_theme', 'vantage_register_custom_background' );


if( !function_exists('vantage_widgets_init') ) :
/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since vantage 1.0
 */
function vantage_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'vantage' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	if( vantage_is_woocommerce_active() ) {
		register_sidebar( array(
			'name' => __( 'Shop', 'vantage' ),
			'id' => 'shop',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}

	register_sidebar( array(
		'name' => __( 'Footer', 'vantage' ),
		'id' => 'sidebar-footer',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Header', 'vantage' ),
		'id' => 'sidebar-header',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
endif;
add_action( 'widgets_init', 'vantage_widgets_init' );


if( !function_exists('vantage_print_styles') ) :
/**
 * Print all the necessary Vantage styles in the header.
 */
function vantage_print_styles(){
	if( !siteorigin_setting('layout_responsive') ) return;

	// Create the footer widget CSS
	$sidebars_widgets = wp_get_sidebars_widgets();
	$count = isset($sidebars_widgets['sidebar-footer']) ? count($sidebars_widgets['sidebar-footer']) : 1;
	$count = max($count,1);

	?>
	<style type="text/css" media="screen">
		#footer-widgets .widget { width: <?php echo round(100/$count,3) . '%' ?>; }
		@media screen and (max-width: 640px) {
			#footer-widgets .widget { width: auto; float: none; }
		}
	</style>
	<?php
}
endif;
add_action('wp_head', 'vantage_print_styles', 11);


if( !function_exists('vantage_scripts') ) :
/**
 * Enqueue scripts and styles
 */
function vantage_scripts() {
	wp_enqueue_style( 'vantage-style', get_stylesheet_uri(), array(), SITEORIGIN_THEME_VERSION );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/fontawesome/css/font-awesome.css', array(), '4.6.2' );
	$in_footer = siteorigin_setting( 'general_js_enqueue_footer' );
	$js_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'jquery-flexslider' , get_template_directory_uri() . '/js/jquery.flexslider' . $js_suffix . '.js' , array('jquery'), '2.1', $in_footer );
	wp_enqueue_script( 'jquery-touchswipe' , get_template_directory_uri() . '/js/jquery.touchSwipe' . $js_suffix . '.js' , array( 'jquery' ), '1.6.6', $in_footer );
	wp_enqueue_script( 'vantage-main' , get_template_directory_uri() . '/js/jquery.theme-main' . $js_suffix . '.js', array( 'jquery' ), SITEORIGIN_THEME_VERSION, $in_footer );

	if( siteorigin_setting( 'layout_fitvids' ) ) {
		wp_enqueue_script( 'jquery-fitvids' , get_template_directory_uri() . '/js/jquery.fitvids' . $js_suffix . '.js' , array('jquery'), '1.0', $in_footer );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply', $in_footer );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'vantage-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation' . $js_suffix . '.js', array( 'jquery' ), '20120202', $in_footer );
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'vantage_scripts' );

if( !function_exists('vantage_web_fonts') ) :
/**
 * Enqueue any webfonts we need
 */
function vantage_web_fonts(){
	if( !siteorigin_setting('logo_image') ) {
		wp_enqueue_style('vantage-google-webfont-roboto', '//fonts.googleapis.com/css?family=Roboto:300');
	}
}
endif;
add_action( 'wp_enqueue_scripts', 'vantage_scripts' );


if( !function_exists('vantage_wp_head') ) :
function vantage_wp_head(){
	?>
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<!--[if (gte IE 6)&(lte IE 8)]>
		<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/selectivizr.js"></script>
	<![endif]-->
	<?php
}
endif;
add_action('wp_head', 'vantage_wp_head');


if( !function_exists('vantage_top_text_area') ) :
/**
 * Display some text in the text area.
 */
function vantage_top_text_area(){
	echo wp_kses_post( siteorigin_setting('logo_header_text') );
}
endif;
add_action('vantage_support_text', 'vantage_top_text_area');

if( !function_exists('vantage_back_to_top') ) :
/**
 * Display the scroll to top link.
 */
function vantage_back_to_top() {
	if( !siteorigin_setting('navigation_display_scroll_to_top') ) return;
	?><a href="#" id="scroll-to-top" title="<?php esc_attr_e('Back To Top', 'vantage') ?>"><span class="vantage-icon-arrow-up"></span></a><?php
}
endif;
add_action('wp_footer', 'vantage_back_to_top');

if( !function_exists('vantage_get_query_variables') ) :
/**
 * @return mixed
 */
function vantage_get_query_variables(){
	global $wp_query;
	$vars = $wp_query->query_vars;
	foreach( $vars as $k => $v ) {
		if(empty($vars[$k])) unset ($vars[$k]);
	}
	unset( $vars['update_post_term_cache'] );
	unset( $vars['update_post_meta_cache'] );
	unset( $vars['cache_results'] );
	unset( $vars['comments_per_page'] );

	return $vars;
}
endif;

if( !function_exists('vantage_render_slider') ) :
/**
 * Render the slider.
 */
function vantage_render_slider(){

	if( is_front_page() && !in_array( siteorigin_setting( 'home_slider' ), array( '', 'none' ) ) ) {
		$settings_slider = siteorigin_setting( 'home_slider' );
		$slider_stretch = siteorigin_setting( 'home_slider_stretch' );

		if(!empty($settings_slider)) {
			$slider = $settings_slider;
		}
	}
	$page_id = get_the_ID();
	$is_wc_shop = vantage_is_woocommerce_active() && is_woocommerce() && is_shop();
	if ( $is_wc_shop ) {
		$page_id = wc_get_page_id( 'shop' );
	}
	if( ( is_page() || $is_wc_shop ) && get_post_meta($page_id, 'vantage_metaslider_slider', true) != 'none' ) {
		$page_slider = get_post_meta($page_id, 'vantage_metaslider_slider', true);
		if( !empty($page_slider) ) {
			$slider = $page_slider;
		}
		$slider_stretch = get_post_meta($page_id, 'vantage_metaslider_slider_stretch', true);
		if( $slider_stretch === '' ) {
			// We'll default to whatever the home page slider stretch setting is
			$slider_stretch = siteorigin_setting('home_slider_stretch');
		}
	}

	if( empty($slider) ) return;

	global $vantage_is_main_slider;
	$vantage_is_main_slider = true;

	?><div id="main-slider" <?php if( $slider_stretch ) echo 'data-stretch="true"' ?>><?php


	if($slider == 'demo') get_template_part('slider/demo');
	elseif( substr($slider, 0, 5) == 'meta:' ) {
		list($null, $slider_id) = explode(':', $slider);

		echo do_shortcode( "[metaslider id=" . intval($slider_id) . "]" );
	}

	?></div><?php
	$vantage_is_main_slider = false;
}
endif;


if( !function_exists('vantage_post_class_filter') ) :
function vantage_post_class_filter($classes){
	$classes[] = 'post';

	if( has_post_thumbnail() && !is_singular() ) {
		$classes[] = 'post-with-thumbnail';
		$classes[] = 'post-with-thumbnail-' . siteorigin_setting( 'blog_featured_image_type' );
	}

	$classes = array_unique($classes);
	return $classes;
}
endif;
add_filter('post_class', 'vantage_post_class_filter');


if( !function_exists('vantage_filter_vantage_post_on_parts') ) :
/**
 * Filter the posted on parts to remove the ones disabled in settings.
 *
 * @param $parts
 * @return mixed
 */
function vantage_filter_vantage_post_on_parts($parts){
	if( !siteorigin_setting('blog_post_date') ) $parts['on'] = '';
	if( !siteorigin_setting('blog_post_author') ) $parts['by'] = '';
	if( !siteorigin_setting('blog_post_comment_count') ) $parts['with'] = '';

	return $parts;
}
endif;
add_filter('vantage_post_on_parts', 'vantage_filter_vantage_post_on_parts');


if( !function_exists('vantage_get_site_width') ) :
/**
 * Get the site width.
 *
 * @return int The side width in pixels.
 */
function vantage_get_site_width(){
	return apply_filters('vantage_site_width', !empty($GLOBALS['vantage_site_width']) ? $GLOBALS['vantage_site_width'] : 1080);
}
endif;


if( !function_exists('vantage_responsive_header') ) :
/**
 * Add the responsive header
 */
function vantage_responsive_header(){
	if( siteorigin_setting('layout_responsive') ) {
		?><meta name="viewport" content="width=device-width, initial-scale=1" /><?php
	}
	else {
		?><meta name="viewport" content="width=1280" /><?php
	}
}
endif;
add_action('wp_head', 'vantage_responsive_header');


if( !function_exists('vantage_footer_site_info_sub') ) :
/**

 * Handles the site title, copyright symbol and year string replace for the Footer Copyright theme option.

 */
function vantage_footer_site_info_sub($copyright){

	return str_replace(
		array('{site-title}', '{copyright}', '{year}'),
		array(get_bloginfo('name'), '&copy;', date('Y')),
		$copyright
	);

}
endif;
add_filter( 'vantage_site_info', 'vantage_footer_site_info_sub' );


if( ! function_exists( 'vantage_filter_mobilenav' ) ) :
function vantage_filter_mobilenav($text){

	if( siteorigin_setting('navigation_responsive_menu_text') ) {
		$text['navigate'] = siteorigin_setting('navigation_responsive_menu_text');
	}
	return $text;
}
endif;
add_filter('siteorigin_mobilenav_text', 'vantage_filter_mobilenav');


if( ! function_exists( 'vantage_filter_mobilenav_collapse' ) ) :
function vantage_filter_mobilenav_collapse($collpase){
	return siteorigin_setting('navigation_responsive_menu_collapse');
}
endif;
add_filter('siteorigin_mobilenav_resolution', 'vantage_filter_mobilenav_collapse');


if( ! function_exists( 'vantage_filter_mobilenav_search' ) ) :
function vantage_filter_mobilenav_search( $search ) {
	if( siteorigin_setting( 'navigation_responsive_menu_search' ) ) {
		return $search;
	}
	return false;
}
endif;
add_filter( 'siteorigin_mobilenav_search', 'vantage_filter_mobilenav_search' );
