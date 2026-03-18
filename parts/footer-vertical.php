<?php
/**
 * Part Name: Vertical Footer
 */
?>
<footer id="colophon" class="site-footer vertical-footer" role="contentinfo">

	<?php if ( ! siteorigin_page_setting( 'hide_footer_widgets', false ) ) { ?>
		<div id="footer-widgets" class="full-container">
			<?php dynamic_sidebar( 'sidebar-footer' ); ?>
		</div><!-- #footer-widgets -->
	<?php } ?>

	<?php
	$site_info_text = apply_filters( 'vantage_site_info', siteorigin_setting( 'general_site_info_text' ) );
	$theme_attribution = apply_filters(
		'vantage_footer_attribution',
		'<span id="theme-attribution">' . sprintf( __( 'Theme by %s', 'vantage' ), '<a href="https://siteorigin.com">SiteOrigin</a>' ) . '</span>'
	);

	if ( ! empty( $site_info_text ) || siteorigin_setting( 'general_privacy_policy_link' ) || ! empty( $theme_attribution ) ) {
		?>
		<div id="site-info">
			<?php
			if ( ! empty( $site_info_text ) ) {
				echo '<span>' . wp_kses_post( $site_info_text ) . '</span>';
			}

			if ( function_exists( 'the_privacy_policy_link' ) && siteorigin_setting( 'general_privacy_policy_link' ) ) {
				the_privacy_policy_link( '<span>', '</span>' );
			}

			if ( ! empty( $theme_attribution ) ) {
				echo wp_kses_post( $theme_attribution );
			}
			?>
		</div><!-- #site-info -->
	<?php } ?>

</footer><!-- #colophon .site-footer .vertical-footer -->
