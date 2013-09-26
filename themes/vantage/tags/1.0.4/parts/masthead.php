<header id="masthead" class="site-header" role="banner">

	<hgroup class="full-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="logo"><?php vantage_display_logo(); ?></a>
		<div class="support-text">
			<?php do_action('vantage_support_text'); ?>
		</div>
	</hgroup>

	<nav role="navigation" class="site-navigation main-navigation primary <?php if( siteorigin_setting('navigation_use_sticky_menu') ) echo 'use-sticky-menu' ?>">
		<div class="full-container">
			<h1 class="assistive-text"><?php _e( 'Menu', 'vantage' ); ?></h1>
			<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'vantage' ); ?>"><?php _e( 'Skip to content', 'vantage' ); ?></a></div>

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