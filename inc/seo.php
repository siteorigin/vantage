<?php

function vantage_display_yaost_seo_breadcrumbs() {
	if ( function_exists('yoast_breadcrumb') && !is_front_page() && siteorigin_setting('navigation_yoast_breadcrumbs') ) {
		yoast_breadcrumb('<div id="yoast-breadcrumbs"><div class="full-container">','</div></div>');
	}
}
add_filter('vantage_main_top', 'vantage_display_yaost_seo_breadcrumbs');