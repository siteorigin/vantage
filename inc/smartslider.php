<?php

/**
 * Add Smart Slider in the Vantage theme.
 *
 * @param $themes
 * @param $current
 * @return string
 */

if ( ! function_exists( 'vantage_smartslider_page_setting_metabox' ) ) :
function vantage_smartslider_page_setting_metabox(){
	add_meta_box('vantage-smartslider-page-slider', __( 'Page Smart Slider', 'vantage'), 'vantage_smartslider_page_setting_metabox_render', 'page', 'side' );
}
endif;
add_action('add_meta_boxes', 'vantage_smartslider_page_setting_metabox');

if ( ! function_exists( 'vantage_smartslider_page_setting_metabox_render' ) ) :
function vantage_smartslider_page_setting_metabox_render($post){
	$smartslider = get_post_meta( $post->ID, 'vantage_smartslider_slider', true );

	$is_home = $post->ID == get_option( 'page_on_front' );
	// If we're on the home page and the user hasn't explicitly set something here use the 'home_slider' theme setting.
	// if ( $is_home && empty( $smartslider ) ) {
	// 	$smartslider = siteorigin_setting( 'home_slider' );
	// }
	$options = siteorigin_smartslider_get_options();
	?>
	<label><strong><?php _e( 'Display Page Smart Slider', 'vantage' ) ?></strong></label>
	<p>
		<select name="vantage_page_smartslider">
			<?php foreach($options as $id => $name) : ?>
				<option value="<?php echo esc_attr( $id ) ?>" <?php selected( $smartslider, $id ) ?>><?php echo esc_html( $name ) ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<?php
	wp_nonce_field('save', '_vantage_smartslider_nonce');
}
endif;

if ( ! function_exists( 'vantage_smartslider_page_setting_save' ) ) :
function vantage_smartslider_page_setting_save( $post_id ){
	if ( empty( $_POST[ '_vantage_smartslider_nonce' ] ) || ! wp_verify_nonce( $_POST[ '_vantage_smartslider_nonce' ], 'save' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	if ( defined( 'DOING_AJAX' ) ) return;

	update_post_meta( $post_id, 'vantage_smartslider_slider', $_POST[ 'vantage_smartslider_slider' ] );

	// If we're on the home page update the 'home_slider' theme setting as well.
	if ( $post_id == get_option( 'page_on_front' ) ) {
		siteorigin_settings_set( 'home_slider', $_POST[ 'vantage_page_smartslider' ] );
	}
}
endif;
add_action( 'save_post', 'vantage_smartslider_page_setting_save' );
