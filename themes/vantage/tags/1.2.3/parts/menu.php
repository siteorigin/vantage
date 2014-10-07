<?php
/**
 * Part Name: Default Menu
 */
?>
<nav role="navigation" class="site-navigation main-navigation primary <?php if( siteorigin_setting('navigation_use_sticky_menu') ) echo 'use-sticky-menu' ?>">
	<div class="full-container">
		<?php if( siteorigin_setting('navigation_menu_search') ) : ?>
			<div id="search-icon">
				<div id="search-icon-icon"><div class="vantage-icon-search"></div></div>
				<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
					<input type="text" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" />
				</form>
			</div>
		<?php endif; ?>

		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'link_before' => '<span class="icon"></span>' ) ); ?>
	</div>
</nav><!-- .site-navigation .main-navigation -->