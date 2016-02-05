<?php

function vantage_premium_upgrade_content(){
	?>
	<h1><?php _e('Upgrade to Vantage Premium', 'vantage') ?></h1>
	<h3><?php _e('Upgrade to Vantage Premium', 'vantage') ?></h3>

	<div class="so-setting-column">

	</div>
	<?php
}
add_action('siteorigin_settings_premium_content', 'vantage_premium_upgrade_content');

/**
 * Add a feature notice
 */
function vantage_upgrade_panels_upgrade_note(){
	?><p><?php printf( __('Additional styles are available in <a href="%s" target="_blank">Vantage Premium</a>.', 'vantage'), admin_url('themes.php?page=premium_upgrade') ) ?></p><?php
}
add_action('siteorigin_panels_widget_after_styles', 'vantage_upgrade_panels_upgrade_note');