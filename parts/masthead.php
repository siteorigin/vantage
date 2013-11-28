<?php
/**
 * Part Name: Default Masthead
 */
?>
<header id="masthead" class="site-header" role="banner">

	<hgroup class="full-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="logo"><?php vantage_display_logo(); ?></a>

		<?php if( is_active_sidebar('sidebar-header') ) : ?>

			<div id="header-sidebar">
				<?php dynamic_sidebar( 'sidebar-header' ); ?>
			</div>

		<?php else : ?>

			<div class="support-text">
				<?php do_action('vantage_support_text'); ?>
			</div>

		<?php endif; ?>

	</hgroup><!-- hgroup.full-container -->

	<nav role="navigation" class="site-navigation main-navigation primary <?php if( siteorigin_setting('navigation_use_sticky_menu') ) echo 'use-sticky-menu' ?>">
		<div class="full-container">
			<?php if( siteorigin_setting('navigation_menu_search') ) : ?>
				<div id="search-icon">
					<div id="search-icon-icon"><div class="icon"></div></div>
					<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
						<input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
					</form>
				</div>
			<?php endif; ?>

			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'link_before' => '<span class="icon"></span>' ) ); ?>
		</div>
	</nav><!-- .site-navigation .main-navigation -->

</header><!-- #masthead .site-header -->