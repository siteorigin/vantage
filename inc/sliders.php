<?php

if ( class_exists( 'MetaSliderPlugin' ) ) :

	/**
	 * Dequeue the FlexSlider script if MetaSlider is loading theirs since
	 * they have a custom version better suited to their plugin.
	 */
	if ( ! function_exists( 'vantage_remove_flexslider_if_metaslider' ) ) :
	function vantage_remove_flexslider_if_metaslider() {
		global $wp_scripts;

		// Check if the user has FlexSlider set
		if ( wp_script_is( 'metaslider-flex-slider' ) ) {

			// Attempt to unregister the script (works only in the footer)
			wp_dequeue_script( 'jquery-flexslider' );

			// Attempt to unload MetaSlider (too late to unload Vantage's version)
			if ( in_array( 'jquery-flexslider', $wp_scripts->done ) ) {

				// Not ideal, but this loads after the head ok to just print the styles anywhere
				$wp_scripts->print_inline_script( 'metaslider-flex-slider', 'after');

				// Dequeue MetaSlider
				wp_dequeue_script( 'metaslider-flex-slider' );
			}
		}
	}
	endif;
	add_action( 'metaslider_register_public_styles', 'vantage_remove_flexslider_if_metaslider', 99 );
	
	/**
	 * Add in the Vantage (Flex) theme.
	 *
	 * @param $themes
	 * @param $current
	 * @return string
	 */
	if ( ! function_exists( 'vantage_metaslider_themes' ) ) :
	function vantage_metaslider_themes( $themes, $current ) {
		$themes .= "<option value='vantage' class='option flex' ".selected( 'vantage', $current, false ).">".__( 'Vantage (Flex)', 'vantage' )."</option>";
		return $themes;
	}
	endif;
	add_filter( 'metaslider_get_available_themes', 'vantage_metaslider_themes', 5, 2 );

	// Change the FlexSlider name space if the Vantage (Flex) theme is selected.
	function vantage_metaslider_flex_params( $options, $slider_id, $settings ) {
	    if ( ! empty($settings['theme'] ) && $settings['theme'] == 'vantage') { 
	        $options['namespace'] = '"flex-vantage-"'; 
	    }
	    return $options;
	} 
	add_filter( 'metaslider_flex_slider_parameters', 'vantage_metaslider_flex_params', 10, 3 );	
	
	if ( ! function_exists( 'vantage_metaslider_filter_flex_slide' ) ) :
	/**
	 * Change the HTML for the home page slider.
	 *
	 * @param $html
	 * @param $slide
	 * @param $settings
	 *
	 * @return string The new HTML
	 */
	function vantage_metaslider_filter_flex_slide( $html, $slide, $settings ) {
		if ( is_admin() && ! empty( $GLOBALS['vantage_is_main_slider'] ) ) return $html;
	
		if ( ! empty( $slide['caption'] ) && function_exists( 'filter_var' ) && filter_var( $slide['caption'], FILTER_VALIDATE_URL ) !== false ) {
	
			$settings['height'] = round( $settings['height'] / 1080 * $settings['width'] );
			$settings['width'] = 1080;
	
			$html = sprintf( "<img src='%s' class='ms-default-image' width='%d' height='%d' />", $slide['thumb'], intval( $settings['width'] ), intval( $settings['height'] ) );
	
			if ( strlen($slide['url'] ) ) {
				$html = '<a href="' . esc_url( $slide['url'] ) . '" target="' . esc_attr( $slide['target'] ) . '">' . $html . '</a>';
			}
	
			$caption = '<div class="content">';
			if ( strlen( $slide['url'] ) ) $caption .= '<a href="' . $slide['url'] . '" target="' . $slide['target'] . '">';
			$caption .= sprintf( '<img src="%s" width="%d" height="%d" />', esc_url( $slide['caption'] ), intval( $settings['width'] ), intval( $settings['height'] ) );
			if ( strlen( $slide['url'] ) ) $caption .= '</a>';
			$caption .= '</div>';
	
			$html = $caption . $html;
	
			$thumb = isset( $slide['data-thumb'] ) && strlen( $slide['data-thumb'] ) ? " data-thumb=\"{$slide['data-thumb']}\"" : "";
	
			$html = '<li style="display: none;"' . $thumb . ' class="vantage-slide-with-image">' . $html . '</li>';
		}
	
		return $html;
	}
	endif;
	add_filter( 'metaslider_image_flex_slider_markup', 'vantage_metaslider_filter_flex_slide', 10, 3 );
	
	if ( ! function_exists( 'vantage_metaslider_ensure_height' ) ) :
	/**
	 * Filter Meta Slider settings when the Vantage (Flex) theme is selected.
	 *
	 * @param $settings
	 */
	function vantage_metaslider_ensure_height( $settings ) {
		if ( ! empty( $settings['theme'] ) && $settings['theme'] == 'vantage' ) {
			$settings['width'] = vantage_get_site_width();
		}
	
		return $settings;
	}
	endif;
	add_filter( 'sanitize_post_meta_ml-slider_settings', 'vantage_metaslider_ensure_height' );
endif; // endif MetaSlider active.

if ( ! function_exists( 'vantage_slider_page_setting_metabox' ) ) :
function vantage_slider_page_setting_metabox(){
	add_meta_box('vantage-slider-page-slider', __('Page Slider', 'vantage'), 'vantage_slider_page_setting_metabox_render', 'page', 'side');
}
endif;
add_action( 'add_meta_boxes', 'vantage_slider_page_setting_metabox' );


if ( ! function_exists( 'vantage_slider_page_setting_metabox_render' ) ) :
function vantage_slider_page_setting_metabox_render( $post ) {
	// Key refers to MetaSlider, but this could be Smart Slider 3 too.
	$slider = get_post_meta( $post->ID, 'vantage_metaslider_slider', true );

	$is_home = $post->ID == get_option( 'page_on_front' );
	// If we're on the home page and the user hasn't explicitly set something here use the 'home_slider' theme setting.
	if ( $is_home && empty( $slider ) ) {
		$slider = siteorigin_setting( 'home_slider' );
	}
	
	// Default stretch setting to theme setting.
	$slider_stretch = siteorigin_setting( 'home_slider_stretch' );
	if ( metadata_exists( 'post', $post->ID, 'vantage_metaslider_slider_stretch' ) ) {
		$slider_stretch = get_post_meta( $post->ID, 'vantage_metaslider_slider_stretch', true );
	}
	$slider_can_stretch = preg_match( '/^(meta:)/', $slider );
	
	wp_enqueue_script(
		'siteorigin-vantage-sliders',
		get_template_directory_uri() . '/inc/sliders/js/sliders' . SITEORIGIN_THEME_JS_PREFIX . '.js',
		array( 'jquery' ),
		SITEORIGIN_THEME_VERSION
	);
	
	// Include the demo slider in the options if it's the home page.
	$options = vantage_sliders_get_options( $is_home );
	?>
	<label><strong><?php _e( 'Display Page Slider', 'vantage' ); ?></strong></label>
	<p>
		<select name="vantage_page_slider">
			<?php foreach ( $options as $id => $name ) : ?>
				<option value="<?php echo esc_attr( $id ) ?>" <?php selected( $slider, $id ) ?>><?php echo esc_html( $name ); ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<p class="checkbox-wrapper" style="display: <?php echo ( ! empty( $slider_can_stretch ) ? 'block' : 'none' ) ?>;">
		<input id="vantage_page_slider_stretch" name="vantage_page_slider_stretch" type="checkbox" <?php checked( $slider_stretch ); ?> />
		<label for="vantage_page_slider_stretch"><?php _e( 'Stretch Page Meta Slider', 'vantage' ); ?></label>
	</p>
	<?php
	wp_nonce_field( 'save', '_vantage_slider_nonce' );
}
endif;

if ( ! function_exists( 'vantage_slider_page_setting_save' ) ) :
function vantage_slider_page_setting_save( $post_id ) {
	if ( empty( $_POST[ '_vantage_slider_nonce' ] ) || ! wp_verify_nonce( $_POST[ '_vantage_slider_nonce' ], 'save' ) ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	if ( defined( 'DOING_AJAX' ) ) return;

	update_post_meta( $post_id, 'vantage_metaslider_slider', $_POST['vantage_page_slider'] );
	$slider_stretch = ! empty( $_POST['vantage_page_slider_stretch'] );
	update_post_meta( $post_id, 'vantage_metaslider_slider_stretch', $slider_stretch );

	// If we're on the home page update the 'home_slider' theme setting as well.
	if ( $post_id == get_option( 'page_on_front' ) ) {
		siteorigin_settings_set( 'home_slider', $_POST[ 'vantage_page_slider' ] );
		siteorigin_settings_set( 'home_slider_stretch', $slider_stretch );
	}
}
endif;
add_action( 'save_post', 'vantage_slider_page_setting_save' );
