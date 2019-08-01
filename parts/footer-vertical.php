<?php
/**
 * Part Name: Vertical Footer
 */
?>
<footer id="colophon" class="site-footer vertical-footer" role="contentinfo">

	<?php if( ! siteorigin_page_setting( 'hide_footer_widgets', false ) ) : ?>
		<div id="footer-widgets" class="full-container">
			<?php dynamic_sidebar( 'sidebar-footer' ) ?>
		</div><!-- #footer-widgets -->
	<?php endif; ?>

	<?php $site_info_text = apply_filters('vantage_site_info', siteorigin_setting('general_site_info_text') ); if( !empty($site_info_text) ) : ?>
		<div id="site-info">
			<?php
				if ( ! empty( $site_info_text ) ) {
					echo '<span>' . wp_kses_post( $site_info_text ) . '</span>';
				}
				if ( function_exists( 'the_privacy_policy_link' ) && siteorigin_setting( 'general_privacy_policy_link' ) ) {
					the_privacy_policy_link( '<span>', '</span>' );
				}
			?>
		</div><!-- #site-info -->
	<?php endif; ?>

	<?php echo apply_filters( 'vantage_footer_attribution', '<div id="theme-attribution">' . sprintf( __('A <a href="%s">SiteOrigin</a> Theme', 'vantage'), 'https://siteorigin.com') . '</div>' ) ?>

</footer><!-- #colophon .site-footer .vertical-footer -->
