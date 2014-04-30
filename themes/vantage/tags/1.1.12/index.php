<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

get_header(); ?>

<div id="primary" class="content-area">

	<div id="content" class="site-content" role="main">

		<?php get_template_part( 'loops/loop', siteorigin_setting('blog_archive_layout') ) ?>

	</div><!-- #content .site-content -->

</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>