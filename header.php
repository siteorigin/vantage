<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="page-wrap">
<div class="content-wrap site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<hgroup>
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<?php vantage_display_logo(); ?>
				</a>
			</h1>

			<div class="support-text">
				<?php do_action('vantage_support_text'); ?>
			</div>
		</hgroup>

		<nav role="navigation" class="site-navigation main-navigation primary">
			<h1 class="assistive-text"><?php _e( 'Menu', 'vantage' ); ?></h1>
			<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'vantage' ); ?>"><?php _e( 'Skip to content', 'vantage' ); ?></a></div>

			<div id="search-icon">
				<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
					<input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
				</form>
			</div>

			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- .site-navigation .main-navigation -->
	</header><!-- #masthead .site-header -->

	<div id="slider">
		<?php get_template_part('slider/demo') ?>
	</div>

	<div id="main" class="site-main">