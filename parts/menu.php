<?php
/**
 * Part Name: Default Menu
 */

$ubermenu_active = function_exists( 'ubermenu' );
$nav_classes = array( 'site-navigation' );
if ( ! $ubermenu_active ) {
	$nav_classes[] = 'main-navigation';
}
$nav_classes[] = 'primary';

if ( siteorigin_setting( 'navigation_use_sticky_menu' ) ) {
	$nav_classes[] = 'use-sticky-menu';
}

if ( siteorigin_setting( 'navigation_mobile_navigation' ) ) {
	$nav_classes[] = 'mobile-navigation';
}
$logo_in_menu = siteorigin_setting( 'layout_masthead' ) == 'logo-in-menu';
?>

<nav role="navigation" class="<?php echo implode( ' ', $nav_classes) ?>">

	<div class="full-container">
		<?php if($logo_in_menu) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="logo"><?php vantage_display_logo(); ?></a>
		<?php endif; ?>
		<?php if( siteorigin_setting('navigation_menu_search') ) : ?>
			<div id="search-icon">
				<div id="search-icon-icon"><div class="vantage-icon-search"></div></div>
				<?php get_search_form() ?>
			</div>
		<?php endif; ?>

		<?php if( $ubermenu_active ): ?>
			<?php ubermenu( 'main' , array( 'menu' => 2 ) ); ?>
		<?php else: ?>
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'link_before' => '<span class="icon"></span>' ) ); ?>
		<?php endif; ?>
	</div>
</nav><!-- .site-navigation .main-navigation -->


