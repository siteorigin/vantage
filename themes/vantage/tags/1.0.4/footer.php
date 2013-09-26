			<?php do_action( 'vantage_main_bottom' ); ?>
		</div><!-- .full-container -->
	</div><!-- #main .site-main -->

	<?php do_action( 'vantage_after_main_container' ); ?>

	<?php do_action( 'vantage_before_footer' ); ?>

	<?php get_template_part( 'parts/footer', apply_filters( 'vantage_footer_type', '' ) ); ?>

	<?php do_action( 'vantage_after_footer' ); ?>

</div><!-- #page-wrapper -->

<?php do_action('vantage_after_page_wrapper') ?>

<?php wp_footer(); ?>

</body>
</html>