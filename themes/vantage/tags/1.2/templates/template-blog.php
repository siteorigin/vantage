<?php
/*
Template Name: Blog
*/

if( !get_option( 'page_for_posts' ) && get_option( 'show_on_front' ) == 'page' && get_post_status() == 'publish' ) {
	// We're transitioning away from using the blog page template
	// Automatically update this so it uses the proper system.
	update_option( 'page_for_posts', get_the_ID() );
	update_post_meta( get_the_ID(), '_wp_page_template', 'default' );
}

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