<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?>

	</div><!-- #main .site-main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div id="footer-widgets">
			<?php dynamic_sidebar( 'sidebar-footer' ) ?>
		</div><!-- #footer-widgets -->
		<div class="site-info">
			<?php do_action( 'vantage_credits' ); ?>
			<?php echo apply_filters( 'vantage_credits_siteorigin', sprintf( __( 'Designed by %1$s.', 'vantage' ), '<a href="http://siteorigin.com/" rel="designer">SiteOrigin</a>' ) ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->

	<div id="theme-attribution">
		A <a href="http://siteorigin.com">SiteOrigin</a> Theme
	</div>
</div><!-- .content-wrap -->
</div><!-- .page-wrap -->

<?php wp_footer(); ?>

</body>
</html>