<footer id="colophon" class="site-footer" role="contentinfo">

	<div id="footer-widgets" class="full-container">
		<?php dynamic_sidebar( 'sidebar-footer' ) ?>
	</div><!-- #footer-widgets -->

	<div class="site-info">
		<?php do_action('vantage_site_info') ?>
	</div><!-- .site-info -->

	<?php echo apply_filters( 'vantage_footer_attribution', '<div id="theme-attribution">' . sprintf( __('A <a href="%s">SiteOrigin</a> Theme'), 'http://siteorigin.com') . '</div>' ) ?>

</footer><!-- #colophon .site-footer -->