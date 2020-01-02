<?php
/**
 * Part Name: Logo In Menu
 */
?>

<header id="masthead" class="site-header masthead-logo-in-menu <?php if ( ! siteorigin_setting( 'logo_in_menu_constrain' ) ) echo ' unconstrained-logo'; ?>" role="banner">

	<?php get_template_part( 'parts/menu', apply_filters( 'vantage_menu_type', siteorigin_setting( 'layout_menu' ) ) ); ?>

</header><!-- #masthead .site-header -->
