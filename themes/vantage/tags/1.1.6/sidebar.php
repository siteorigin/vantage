<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php do_action( 'after_sidebar' ); ?>
</div><!-- #secondary .widget-area -->
