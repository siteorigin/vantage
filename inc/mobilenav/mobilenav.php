<?php

if( !function_exists('siteorigin_mobilenav_enqueue_scripts') ) :
/**
 * Enqueue everything for the mobile navigation.
 *
 * @action wp_enqueue_scripts
 */
function siteorigin_mobilenav_enqueue_scripts() {
	wp_enqueue_script( 'siteorigin-mobilenav', get_template_directory_uri() . '/inc/mobilenav/js/mobilenav' . SITEORIGIN_THEME_JS_PREFIX . '.js', array( 'jquery' ), SITEORIGIN_THEME_VERSION );

	$text = array(
		'navigate' => __( 'Menu', 'vantage' ),
		'back' => __( 'Back', 'vantage' ),
		'close' => __( 'Close', 'vantage' ),
	);
	if( siteorigin_setting('navigation_responsive_menu_text') ) {
		$text['navigate'] = siteorigin_setting('navigation_responsive_menu_text');
	}
	$text = apply_filters('siteorigin_mobilenav_text', $text);

	$search = array( 'url' => get_home_url(), 'placeholder' => __( 'Search', 'vantage' ) );
	$search = apply_filters('siteorigin_mobilenav_search', $search);

	wp_localize_script( 'siteorigin-mobilenav', 'mobileNav', array(
		'search' => $search,
		'text' => $text,
		'nextIconUrl' => get_template_directory_uri() . '/inc/mobilenav/images/next.png',
	) );
	wp_enqueue_style( 'siteorigin-mobilenav', get_template_directory_uri() . '/inc/mobilenav/css/mobilenav.css', array(), SITEORIGIN_THEME_VERSION );
}
endif;
add_action( 'wp_enqueue_scripts', 'siteorigin_mobilenav_enqueue_scripts' );

if( !function_exists('siteorigin_mobilenav_nav_filter') ) :
/**
 * Filter navigation menu to add mobile markers.
 *
 * @param $nav_menu
 * @param $args
 * @return string
 */
function siteorigin_mobilenav_nav_filter($nav_menu, $args){
	$args = (object) $args;
	if( empty($args->theme_location) && !apply_filters('siteorigin_mobilenav_is_valid', false, $args) ) return $nav_menu;

	static $mobile_nav_id = 1;

	// Add a marker so we can find this menu later
	$nav_menu = '<div id="so-mobilenav-standard-'.$mobile_nav_id.'" data-id="'.$mobile_nav_id.'" class="so-mobilenav-standard"></div>'.$nav_menu;

	// Add the mobile navigation marker
	$nav_menu .= '<div id="so-mobilenav-mobile-'.$mobile_nav_id.'" data-id="'.$mobile_nav_id.'" class="so-mobilenav-mobile"></div>';

	// Create the mobile navigation
	$class = $args->container_class ? ' class="' . esc_attr( $args->container_class ) . '" menu-mobilenav-container' : ' class="menu-mobilenav-container"';
	$id = $args->container_id ? ' id="' . esc_attr( $args->container_id ) . '"' : '';
	$nav_menu .= '<'. $args->container . $id . $class . '>';

	$text = array(
		'navigate' => __( 'Menu', 'vantage' ),
		'back' => __( 'Back', 'vantage' ),
		'close' => __( 'Close', 'vantage' ),
	);
	$text = apply_filters('siteorigin_mobilenav_text', $text);

	$wrap_class = $args->menu_class ? $args->menu_class : '';
	$wrap_id = 'mobile-nav-item-wrap-'.$mobile_nav_id;
	$items = '<li><a href="#" class="mobilenav-main-link" data-id="'.$mobile_nav_id.'"><span class="mobile-nav-icon"></span>'.$text['navigate'].'</a></li>';

	$nav_menu .= sprintf( $args->items_wrap, esc_attr( $wrap_id ), esc_attr( $wrap_class ), $items );

	$nav_menu .= '</' . $args->container . '>';

	$mobile_nav_id++;

	return $nav_menu;
}
endif;
add_filter('wp_nav_menu', 'siteorigin_mobilenav_nav_filter', 10, 2);
add_filter('wp_page_menu', 'siteorigin_mobilenav_nav_filter', 10, 2);

if( !function_exists('siteorigin_mobilenav_nav_menu_css') ) :
function siteorigin_mobilenav_nav_menu_css(){
	$mobile_resolution = apply_filters('siteorigin_mobilenav_resolution', 480);

	if ( $mobile_resolution != 0 ) : ?>
		<style type="text/css">
			.so-mobilenav-mobile + * { display: none; }
			@media screen and (max-width: <?php echo intval($mobile_resolution) ?>px) { .so-mobilenav-mobile + * { display: block; } .so-mobilenav-standard + * { display: none; } }
		</style>
	<?php else : ?>
		<style type="text/css">
			.so-mobilenav-mobile + * { display: block; } .so-mobilenav-standard + * { display: none; }
		</style>
	<?php endif;
}
endif;
add_action('wp_head', 'siteorigin_mobilenav_nav_menu_css');

if( !function_exists('siteorigin_mobilenav_body_class') ) :
/**
 * Add custom body classes.
 *
 * @param $classes
 * @return array
 */
function siteorigin_mobilenav_body_class($classes){
	$classes[] = 'mobilenav';
	return $classes;
}
endif;
add_filter('body_class', 'siteorigin_mobilenav_body_class');
