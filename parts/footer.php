<footer id="colophon" class="site-footer" role="contentinfo">

	<div id="footer-widgets" class="full-container">
		<?php dynamic_sidebar( 'sidebar-footer' ) ?>
	</div><!-- #footer-widgets -->
	<div class="site-info">
		<?php do_action( 'vantage_credits' ); ?>
		<?php echo apply_filters( 'vantage_credits_siteorigin', sprintf( __( 'Designed by %1$s.', 'vantage' ), '<a href="http://siteorigin.com/" rel="designer">SiteOrigin</a>' ) ); ?>
	</div><!-- .site-info -->

	<?php echo apply_filters( 'vantage_footer_attribution', '<div id="theme-attribution">' . sprintf( __('A <a href="%s">SiteOrigin</a> Theme'), 'http://siteorigin.com') . '</div>' ) ?>

</footer><!-- #colophon .site-footer -->