<?php

function vantage_add_legacy_settings_page(){
	add_theme_page(
		__( 'Theme Settings', 'vantage' ),
		__( 'Theme Settings', 'vantage' ),
		'manage_options',
		'vantage-legacy-settings',
		'vantage_legacy_settings_page'
	);
}
add_action( 'admin_menu', 'vantage_add_legacy_settings_page' );

function vantage_legacy_settings_page(){
	?>
	<div class="wrap">
		<h2><?php _e( 'Vantage Settings Have Moved', 'vantage' ) ?></h2>
		<p>
			<?php _e( 'Our theme settings now take advantage of the WordPress customizer.', 'vantage' ); ?>
			<?php _e( 'Navigate to <strong>Appearance > Customize > Theme Settings</strong> to access theme settings.', 'vantage' ); ?>
		</p>
	</div>
	<?php
}