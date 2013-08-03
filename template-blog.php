<?php
/*
Template Name: Blog
*/

add_filter('option_show_on_front', '__return_false');
global $wp_query;
query_posts(array(
	'paged' => $wp_query->get('paged'),
));
get_template_part('index');
remove_filter('option_show_on_front', '__return_false');

wp_reset_query();
wp_reset_postdata();