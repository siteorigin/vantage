<?php
/**
 * This page just renders our blog archive. Mainly useful if we've created a custom home page and still want to make use of the blog archive.
 * 
 * @package vantage
 * @since vantage 1.0
 * 
 * Template Name: Blog Archive
 */

vantage_set_is_blog_archive(true);
global $wp_query;
query_posts(array(
	'paged' => $wp_query->get('paged'),
));
get_template_part('index');
vantage_set_is_blog_archive(false);

wp_reset_query();
wp_reset_postdata();