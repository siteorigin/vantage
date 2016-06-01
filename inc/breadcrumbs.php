<?php

if( !function_exists('vantage_display_breadcrumbs') ) :
function vantage_display_breadcrumbs() {
	if ( !is_front_page() && siteorigin_setting('navigation_yoast_breadcrumbs') ) {
		if ( function_exists('bcn_display') ) {
			?><div id="navxt-breadcrumbs">
				<div class="full-container">
					<?php bcn_display(); ?>
				</div>
			</div><?php
		} elseif ( function_exists('yoast_breadcrumb') ) {
			yoast_breadcrumb('<div id="yoast-breadcrumbs"><div class="full-container">','</div></div>');
		}
	}
}
endif;

// Support for deprecated function vantage_display_yoast_seo_breadcrumbs
if ( !function_exists('vantage_display_yoast_seo_breadcrumbs') ) {
	add_filter('vantage_main_top', 'vantage_display_breadcrumbs');
} else {
	add_filter('vantage_main_top', 'vantage_display_yoast_seo_breadcrumbs');
}
