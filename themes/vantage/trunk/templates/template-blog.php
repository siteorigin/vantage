<?php
/*
Template Name: Blog
*/

add_filter('option_show_on_front', '__return_false');
add_filter('siteorigin_panels_is_home', '__return_false');
global $wp_query;
query_posts(array(
	'paged' => $wp_query->get('paged'),
));
global $more; $more = 0;
get_template_part('index');
$more = 1;
remove_filter('option_show_on_front', '__return_false');
remove_filter('siteorigin_panels_is_home', '__return_false');

wp_reset_query();
wp_reset_postdata();