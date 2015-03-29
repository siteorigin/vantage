<?php

/**
 * Initialize the page layout
 */
function vantage_page_layout_init(){

}
add_action('after_setup_theme', 'vantage_page_layout_init');

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
 * Get the layout meta value
 *
 * @param $post_id
 *
 * @return array|mixed
 */
function vantage_page_layout_get_layout($post_id, $value = false) {
	$meta = get_post_meta($post_id, 'vantage_page_layout', true);
	if( empty($meta) ) $meta = vantage_page_layout_get_from_template($post_id);

	// Return the meta value
	if( empty($value) || empty($meta[$value]) ) return $meta;
	else return $meta[$value];
}

/**
 * Get the page layout values based on the given template
 *
 * @param $post_id
 *
 * @return array
 */
function vantage_page_layout_get_from_template($post_id){
	//$template = get_post_meta($post_id, '');
	$template = get_page_template_slug($post_id);
	switch( $template ) {
		case 'default' :
			return array(
				'show_title' => 'yes',
				'width' => 'normal',
			);

		case 'home-panels.php' :
		case 'home-panels-notitle.php' :
			return array(
				'show_title' => 'no',
				'width' => 'full-width',
			);

		case 'templates/template-full.php':
			return array(
				'show_title' => 'yes',
				'width' => 'full-width',
			);
	}

	return array();
}

/**
 * Render the metabox
 *
 * @param WP_Post $post
 */
function vantage_page_layout_metabox_render($post){
	$layout = get_post_meta( $post->ID, 'vantage_page_layout', true );
	if( empty($layout) ) {
		$layout = vantage_page_layout_get_from_template($post->ID);
	}

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

/**
 * Save these values to the meta field
 *
 * @param $post_id
 */
function vantage_page_layout_save($post_id){
	if( empty( $_POST['vantage_page_layout'] ) ) return;
	if( !current_user_can('edit_post', $post_id) ) return;
	if( !wp_verify_nonce( filter_input(INPUT_POST, '_vantage_metabox_nonce'), 'vantage_save_layout' ) ) return;

	$values = $_POST['vantage_page_layout'];
	$values = array_map( 'sanitize_text_field', $values);
	update_post_meta( $post_id, 'vantage_page_layout', $values );

	// Don't use the panels-home.php template if we're trying to change the display
	if( ( get_page_template_slug($post_id) == 'home-panels.php' ) && ( $values['width'] != 'full-width' || $values['show_title'] != 'no' ) ) {
		update_post_meta( $post_id, '_wp_page_template', 'default' );
	}


}
add_action('save_post', 'vantage_page_layout_save');

/**
 * Filter the body classes
 *
 * @param $classes
 */
function vantage_page_layout_body_classes($classes){
	if( is_page() ) {
		$layout = vantage_page_layout_get_layout( get_the_ID() );
		foreach( $layout as $k => $v ) {
			$classes[] = sanitize_html_class( 'vantage-layout-' . str_replace('_', '-', $k) . '-' . str_replace('_', '-', $v) );
		}
	}

	return $classes;
}
add_filter( 'body_class', 'vantage_page_layout_body_classes' );