<?php
/**
 * Part Name: Logo In Menu
 */
?>

<header id="masthead" class="site-header masthead-logo-in-menu" role="banner">

	<?php if( is_active_sidebar( 'sidebar-masthead' ) ) : ?>

		<div class="hgroup full-container masthead-sidebar">

			<?php dynamic_sidebar( 'sidebar-masthead' ); ?>

		</div>

	<?php endif; ?>

	<?php get_template_part( 'parts/menu', apply_filters( 'vantage_menu_type', siteorigin_setting( 'layout_menu' ) ) ); ?>

</header><!-- #masthead .site-header -->
