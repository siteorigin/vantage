<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @since vantage 1.0
 *
 * @license GPL 2.0
 */
if ( ! function_exists( 'vantage_page_menu_args' ) ) {
	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 *
	 * @since vantage 1.0
	 */
	function vantage_page_menu_args( $args ) {
		$args['show_home'] = true;

		return $args;
	}
}
add_filter( 'wp_page_menu_args', 'vantage_page_menu_args' );

if ( ! function_exists( 'vantage_body_classes' ) ) {
	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * @since vantage 1.0
	 */
	function vantage_body_classes( $classes ) {
		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		if ( siteorigin_setting( 'layout_responsive' ) ) {
			$classes[] = 'responsive';
		}
		$classes[] = 'layout-' . siteorigin_setting( 'layout_bound' );
		$classes[] = 'no-js';

		$is_full_width_template = is_page_template( 'templates/template-full.php' ) || is_page_template( 'templates/template-full-notitle.php' );

		if ( ! $is_full_width_template ) {
			// Is WooCommerce active, is the Shop sidebar populated, are we viewing a WooCommerce page?
			$wc_shop_sidebar = vantage_is_woocommerce_active() && is_active_sidebar( 'shop' ) && is_woocommerce();

			if ( ! is_active_sidebar( 'sidebar-1' ) && ! $wc_shop_sidebar ) {
				$classes[] = 'no-sidebar';
			} else {
				$classes[] = 'has-sidebar';
			}
		}

		if ( is_customize_preview() ) {
			$classes[] = 'so-vantage-customizer-preview';
		}

		if ( wp_is_mobile() ) {
			$classes[] = 'so-vantage-mobile-device';
		}
		$mega_menu_active = function_exists( 'max_mega_menu_is_enabled' ) && max_mega_menu_is_enabled( 'primary' );

		if ( siteorigin_setting( 'navigation_menu_search' ) && ! $mega_menu_active ) {
			$classes[] = 'has-menu-search';
		}

		if ( siteorigin_setting( 'layout_force_panels_full' ) ) {
			$classes[] = 'panels-style-force-full';
		}

		$page_settings = siteorigin_page_setting();

		if ( ! empty( $page_settings ) ) {
			if ( ! empty( $page_settings['layout'] ) ) {
				$classes[] = 'page-layout-' . $page_settings['layout'];
			}

			if ( empty( $page_settings['masthead_margin'] ) ) {
				$classes[] = 'page-layout-no-masthead-margin';
			}

			if ( empty( $page_settings['footer_margin'] ) ) {
				$classes[] = 'page-layout-no-footer-margin';
			}

			if ( ! empty( $page_settings['hide_masthead'] ) ) {
				$classes[] = 'page-layout-hide-masthead';
			}

			if ( ! empty( $page_settings['hide_footer_widgets'] ) ) {
				$classes[] = 'page-layout-hide-footer-widgets';
			}
		}

		if ( is_page() && is_page_template() ) {
			$classes[] = 'not-default-page';
		}

		// WooCommerce.
		if ( vantage_is_woocommerce_active() ) {
			if ( siteorigin_setting( 'woocommerce_mini_cart' ) && ! ( is_cart() || is_checkout() ) ) {
				$classes[] = 'has-mini-cart';
			}
		}

		return $classes;
	}
}
add_filter( 'body_class', 'vantage_body_classes' );

if ( ! function_exists( 'vantage_enhanced_image_navigation' ) ) {
	/**
	 * Filter in a link to a content ID attribute for the next/previous image links on image attachment pages
	 *
	 * @since vantage 1.0
	 */
	function vantage_enhanced_image_navigation( $url, $id ) {
		if ( ! is_attachment() && ! wp_attachment_is_image( $id ) ) {
			return $url;
		}

		$image = get_post( $id );

		if ( ! empty( $image->post_parent ) && $image->post_parent != $id ) {
			$url .= '#main';
		}

		return $url;
	}
}
add_filter( 'attachment_link', 'vantage_enhanced_image_navigation', 10, 2 );

if ( ! function_exists( 'vantage_footer_widget_style' ) ) {
	/**
	 * Add the styles to set the size of the footer widgets.
	 */
	function vantage_footer_widget_style() {
		$widgets = wp_get_sidebars_widgets();

		if ( empty( $widgets['sidebar-footer'] ) ) {
			return;
		}

		$count = count( $widgets['sidebar-footer'] );
		?><style type="text/css" id="vantage-footer-widgets">#footer-widgets aside { width : <?php echo round( 100 / $count, 3 ); ?>%; }</style> <?php
	}
}
add_action( 'wp_head', 'vantage_footer_widget_style', 15 );

if ( ! function_exists( 'vantage_excerpt_length' ) ) {
	/*
	 * Filter the except length.
	 */
	function vantage_excerpt_length( $length ) {
		return siteorigin_setting( 'blog_excerpt_length' );
	}
}
add_filter( 'excerpt_length', 'vantage_excerpt_length', 10 );
