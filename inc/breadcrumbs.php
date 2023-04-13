<?php

if ( ! function_exists( 'vantage_display_breadcrumbs' ) ) {
	function vantage_display_breadcrumbs() {
		if ( ! is_front_page() && siteorigin_setting( 'navigation_yoast_breadcrumbs' ) ) {
			siteorigin_settings_breadcrumbs( 'full-container' );
		}
	}
}

// Support for deprecated function vantage_display_yoast_seo_breadcrumbs.
if ( ! function_exists( 'vantage_display_yoast_seo_breadcrumbs' ) ) {
	add_filter( 'vantage_main_top', 'vantage_display_breadcrumbs' );
} else {
	add_filter( 'vantage_main_top', 'vantage_display_yoast_seo_breadcrumbs' );
}
