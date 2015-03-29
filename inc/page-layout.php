<?php

function vantage_page_layout_metabox(){
	add_meta_box(
		'vantage_page_layout',
		__( 'Page Layout', 'vantage' ),
		'vantage_page_layout_metabox_render',
		'page',
		'side'
	);
}
add_action( 'add_meta_boxes', 'vantage_page_layout_metabox' );

/**
 * Render the metabox
 *
 * @param WP_Post $post
 */
function vantage_page_layout_metabox_render($post){

	$layout = get_post_meta( $post->ID, 'vantage_page_layout', true );
	$layout = wp_parse_args( $layout, array(
		'show_title' => 'yes',
		'width' => 'normal',
	) );

	?>

	<p><label><strong><?php _e('Show Page Title', 'vantage') ?></strong></label></p>
	<select name="vantage_page_layout[show_title]">
		<option value="yes" <?php selected( $layout['show_title'], 'yes' ) ?>><?php esc_html_e('Yes', 'vantage') ?></option>
		<option value="no" <?php selected( $layout['show_title'], 'no' ) ?>><?php esc_html_e('No', 'vantage') ?></option>
	</select>

	<p><label><strong><?php _e('Page Width', 'vantage') ?></strong></label></p>
	<select name="vantage_page_layout[width]">
		<option value="normal" <?php selected( $layout['width'], 'normal' ) ?>><?php esc_html_e('Normal', 'vantage') ?></option>
		<option value="full-width" <?php selected( $layout['width'], 'full-width' ) ?>><?php esc_html_e('Full Width', 'vantage') ?></option>
		<option value="full-width-stretched" <?php selected( $layout['width'], 'full-width-stretched' ) ?>><?php esc_html_e('Full Width (Stretched)', 'vantage') ?></option>
	</select>

	<?php wp_nonce_field('vantage_save_layout', '_vantage_metabox_nonce') ?>

	<?php
}

function vantage_page_layout_save($post_id){
	if( empty( $_POST['vantage_page_layout'] ) ) return;
	if( !current_user_can('edit_post', $post_id) ) return;
	if( !wp_verify_nonce( filter_input(INPUT_POST, '_vantage_metabox_nonce'), 'vantage_save_layout' ) ) return;

	$values = $_POST['vantage_page_layout'];
	$values = array_map( 'sanitize_text_field', $values);
	update_post_meta( $post_id, 'vantage_page_layout', $values );
}
add_action('save_post', 'vantage_page_layout_save');