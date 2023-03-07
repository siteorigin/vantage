<?php

if ( ! function_exists( 'siteorigin_mobilenav_enqueue_scripts' ) ) {
	/**
	 * Enqueue everything for the mobile navigation.
	 *
	 * @action wp_enqueue_scripts
	 */
	function siteorigin_mobilenav_enqueue_scripts() {
		wp_enqueue_script(
			'siteorigin-mobilenav',
			get_template_directory_uri() . '/inc/mobilenav/js/mobilenav' . SITEORIGIN_THEME_JS_PREFIX . '.js',
			array( 'jquery' ),
			SITEORIGIN_THEME_VERSION
		);

		$text = array(
			'navigate' => __( 'Menu', 'vantage' ),
			'back' => __( 'Back', 'vantage' ),
			'close' => __( 'Close', 'vantage' ),
		);

		if ( siteorigin_setting( 'navigation_responsive_menu_text' ) ) {
			$text['navigate'] = siteorigin_setting( 'navigation_responsive_menu_text' );
		}
		$text = apply_filters( 'siteorigin_mobilenav_text', $text );

		$search = array( 'url' => get_home_url(), 'placeholder' => __( 'Search', 'vantage' ) );
		$search = apply_filters( 'siteorigin_mobilenav_search', $search );

		wp_localize_script( 'siteorigin-mobilenav', 'mobileNav', array(
			'search' => $search,
			'text' => $text,
			'nextIconUrl' => get_template_directory_uri() . '/inc/mobilenav/images/next.png',
			'mobileMenuClose' => vantage_display_icon( 'mobile-menu-close' ),
		) );

		wp_enqueue_style(
			'siteorigin-mobilenav',
			get_template_directory_uri() . '/inc/mobilenav/css/mobilenav.css',
			array(),
			SITEORIGIN_THEME_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'siteorigin_mobilenav_enqueue_scripts' );

if ( ! function_exists( 'siteorigin_mobilenav_nav_filter' ) ) {
	/**
	 * Filter navigation menu to add mobile markers.
	 *
	 * @return string
	 */
	function siteorigin_mobilenav_nav_filter( $nav_menu, $args ) {
		if ( function_exists( 'max_mega_menu_is_enabled' ) && max_mega_menu_is_enabled( $args->theme_location ) ) {
			return $nav_menu;
		}

		$args = (object) $args;

		if ( empty( $args->theme_location ) && ! apply_filters( 'siteorigin_mobilenav_is_valid', false, $args ) ) {
			return $nav_menu;
		}

		static $mobile_nav_id = 1;

		// Add a marker so we can find this menu later.
		$nav_menu = '<div id="so-mobilenav-standard-' . $mobile_nav_id . '" data-id="' . $mobile_nav_id . '" class="so-mobilenav-standard"></div>' . $nav_menu;

		// Add the mobile navigation marker.
		$nav_menu .= '<div id="so-mobilenav-mobile-' . $mobile_nav_id . '" data-id="' . $mobile_nav_id . '" class="so-mobilenav-mobile"></div>';

		// Create the mobile navigation.
		$class = $args->container_class ? ' class="' . esc_attr( $args->container_class ) . '" menu-mobilenav-container' : ' class="menu-mobilenav-container"';
		$id = $args->container_id ? ' id="' . esc_attr( $args->container_id ) . '"' : '';
		$nav_menu .= '<' . $args->container . $id . $class . '>';

		$text = array(
			'navigate' => __( 'Menu', 'vantage' ),
			'back' => __( 'Back', 'vantage' ),
			'close' => __( 'Close', 'vantage' ),
		);
		$text = apply_filters( 'siteorigin_mobilenav_text', $text );

		$wrap_class = $args->menu_class ? $args->menu_class : '';
		$wrap_id = 'mobile-nav-item-wrap-' . $mobile_nav_id;
		$items = '<li><a href="#" class="mobilenav-main-link" data-id="' . $mobile_nav_id . '">' . vantage_display_icon( 'mobile-menu' ) . '<span class="mobilenav-main-link-text">' . $text['navigate'] . '</span></a></li>';

		$nav_menu .= sprintf( $args->items_wrap, esc_attr( $wrap_id ), esc_attr( $wrap_class ), $items );

		$nav_menu .= '</' . $args->container . '>';

		$mobile_nav_id++;

		if ( is_customize_preview() ) {
			$nav_menu = '<div class="mobile-nav-customize-wrapper">' . $nav_menu . '</div>';
		}

		return $nav_menu;
	}
}
add_filter( 'wp_nav_menu', 'siteorigin_mobilenav_nav_filter', 10, 2 );
add_filter( 'wp_page_menu', 'siteorigin_mobilenav_nav_filter', 10, 2 );

if ( ! function_exists( 'siteorigin_mobilenav_nav_menu_css' ) ) {
	function siteorigin_mobilenav_nav_menu_css() {
		$mobile_resolution = apply_filters( 'siteorigin_mobilenav_resolution', 480 );

		if ( $mobile_resolution != 0 ) { ?>
			<style type="text/css">
				.so-mobilenav-mobile + * { display: none; }
				@media screen and (max-width: <?php echo intval( $mobile_resolution ); ?>px) { .so-mobilenav-mobile + * { display: block; } .so-mobilenav-standard + * { display: none; } .site-navigation #search-icon { display: none; } .has-menu-search .main-navigation ul { margin-right: 0 !important; }
					<?php if ( class_exists( 'WooCommerce' ) && siteorigin_setting( 'woocommerce_mini_cart' ) ) { ?>
						.site-header .shopping-cart { position: relative; }
					<?php } ?>
				}
			</style>
		<?php } else { ?>
			<style type="text/css">
				.so-mobilenav-mobile + * { display: block; } .so-mobilenav-standard + * { display: none; }
			</style>
			<?php
		}

		if ( is_customize_preview() && siteorigin_setting( 'layout_masthead' ) == 'logo-in-menu' ) {
			if ( has_nav_menu( 'primary' ) ) {
				?>
				<style type="text/css">
					@media screen and (max-width: <?php echo intval( $mobile_resolution ); ?>px) {
						.site-header div[data-customize-partial-type="nav_menu_instance"] { margin-right: 0; margin-left: auto; }
					}
				</style>
			<?php } else { ?>
				<style type="text/css">
					@media screen and (max-width: <?php echo intval( $mobile_resolution ); ?>px) {
						.site-header .mobile-nav-customize-wrapper { margin-right: 0; margin-left: auto; }
					}
				</style>
				<?php
			}
		}
	}
}
add_action( 'wp_head', 'siteorigin_mobilenav_nav_menu_css' );

if ( ! function_exists( 'siteorigin_mobilenav_body_class' ) ) {
	/**
	 * Add custom body classes.
	 *
	 * @return array
	 */
	function siteorigin_mobilenav_body_class( $classes ) {
		$classes[] = 'mobilenav';

		return $classes;
	}
}
add_filter( 'body_class', 'siteorigin_mobilenav_body_class' );
