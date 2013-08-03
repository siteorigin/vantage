<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package sostarter
 * @since sostarter 1.0
 * @license GPL 2.0
 */
?>

	</div><!-- #main .site-main -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div id="footer-widgets">
			<?php dynamic_sidebar( 'sidebar-footer' ) ?>
		</div><!-- #footer-widgets -->
		<div class="site-info">
			<?php do_action( 'sostarter_credits' ); ?>
			<?php echo apply_filters( 'sostarter_credits_siteorigin', sprintf( __( 'Designed by %1$s.', 'sostarter' ), '<a href="http://siteorigin.com/" rel="designer">SiteOrigin</a>' ) ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>