<?php
/**
 * The Sidebar for WooCommerce Shop pages.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

if( ! in_array( siteorigin_page_setting( 'layout', 'default' ), array( 'default','full-width-sidebar' ), true )  ) return;
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php do_action( 'before_sidebar' ); ?>
	<?php is_active_sidebar( 'shop' ) ? dynamic_sidebar( 'shop' ) : dynamic_sidebar( 'sidebar-1' ); ?>
	<?php do_action( 'after_sidebar' ); ?>
</div><!-- #secondary .widget-area -->
