<?php

/**
 * Add in the Vantage theme.
 *
 * @param $themes
 * @param $current
 * @return string
 */
function vantage_metaslider_themes($themes, $current){
	$themes .= "<option value='vantage' class='option flex' ".selected('vantage', $current, false).">".__('Vantage (Flex)', 'vantage')."</option>";
	return $themes;
}
add_filter('metaslider_get_available_themes', 'vantage_metaslider_themes', 5, 2);

/**
 * Change the HTML for the home page slider.
 *
 * @param $html
 * @param $slide
 * @param $settings
 *
 * @return string The new HTML
 */
function vantage_metaslider_filter_flex_slide($html, $slide, $settings){
	if( is_admin() && !empty($GLOBALS['vantage_is_main_slider']) ) return $html;

	if(!empty($slide['caption']) && function_exists('filter_var') && filter_var($slide['caption'], FILTER_VALIDATE_URL) !== false) {

		$settings['height'] = round( $settings['height'] / 1080 * $settings['width'] );
		$settings['width'] = 1080;

		$html = sprintf("<img src='%s' class='msDefaultImage' width='%d' height='%d' />", $slide['thumb'], intval($settings['width']), intval($settings['height']));

		if (strlen($slide['url'])) {
			$html = '<a href="' . esc_url( $slide['url'] ) . '" target="' . esc_attr( $slide['target'] ) . '">' . $html . '</a>';
		}

		$caption = '<div class="content">';
		if (strlen($slide['url'])) $caption .= '<a href="' . $slide['url'] . '" target="' . $slide['target'] . '">';
		$caption .= sprintf('<img src="%s" width="%d" height="%d" />', esc_url($slide['caption']), intval($settings['width']), intval($settings['height']));
		if (strlen($slide['url'])) $caption .= '</a>';
		$caption .= '</div>';

		$html = $caption . $html;

		$thumb = isset($slide['data-thumb']) && strlen($slide['data-thumb']) ? " data-thumb=\"{$slide['data-thumb']}\"" : "";

		$html = '<li style="display: none;"' . $thumb . ' class="vantage-slide-with-image">' . $html . '</li>';
	}

	return $html;
}
add_filter('metaslider_image_flex_slider_markup', 'vantage_metaslider_filter_flex_slide', 10, 3);

/**
 * Filter metaslider settings when Vantage setting is selected.
 *
 * @param $settings
 */
function vantage_metaslider_ensure_height($settings){
	if(!empty($settings['theme']) && $settings['theme'] == 'vantage') {
		$settings['width'] = vantage_get_site_width();
	}

	return $settings;
}
add_filter('sanitize_post_meta_ml-slider_settings', 'vantage_metaslider_ensure_height');

function vantage_metaslider_page_setting_metabox(){
	add_meta_box('vantage-metaslider-page-slider', __('Page Meta Slider', 'vantage'), 'vantage_metaslider_page_setting_metabox_render', 'page', 'side');
}
add_action('add_meta_boxes', 'vantage_metaslider_page_setting_metabox');

function vantage_metaslider_page_setting_metabox_render($post){
	$metaslider = get_post_meta($post->ID, 'vantage_metaslider_slider', true);
	$options = siteorigin_metaslider_get_options(false);

	?>
	<label><?php _e('Display Page Metaslider', 'vantage') ?></label>
	<select name="vantage_page_metaslider">
		<?php foreach($options as $id => $name) : ?>
			<option value="<?php echo esc_attr($id) ?>" <?php selected($metaslider, $id) ?>><?php echo esc_html($name) ?></option>
		<?php endforeach; ?>
	</select>
	<?php
	wp_nonce_field('save', '_vantage_metaslider_nonce');
}

function vantage_metaslider_page_setting_save($post_id){
	if( empty($_POST['_vantage_metaslider_nonce']) || !wp_verify_nonce($_POST['_vantage_metaslider_nonce'], 'save') ) return;
	if( !current_user_can('edit_post', $post_id) ) return;
	if( defined('DOING_AJAX') ) return;

	update_post_meta($post_id, 'vantage_metaslider_slider', $_POST['vantage_page_metaslider']);
}
add_action('save_post', 'vantage_metaslider_page_setting_save');