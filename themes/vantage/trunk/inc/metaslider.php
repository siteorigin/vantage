<?php

function vantage_metaslider_themes($themes, $current){
	$themes .= "<option value='vantage' class='option flex' ".selected('vantage', $current).">".__('Vantage (Flex)', 'vantage')."</option>";
	return $themes;
}
add_filter('metaslider_get_available_themes', 'vantage_metaslider_themes', 5, 2);

/**
 * Change the HTML for the home page slider.
 *
 * @param $html
 * @param $slide
 * @param $settings
 */
function vantage_metaslider_filter_flex_slide($html, $slide, $settings){
	if( is_admin() ) return $html;

	if(!empty($slide['caption']) && function_exists('filter_var') && filter_var($slide['caption'], FILTER_VALIDATE_URL) !== false) {

		$html = sprintf("<img src='%s' class='msDefaultImage' width='%d' width='%d' />", $slide['thumb'], intval($settings['width']), intval($settings['height']));

		if (strlen($slide['url'])) {
			$html = '<a href="' . $slide['url'] . '" target="' . $slide['target'] . '">' . $html . '</a>';
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

	error_log($html);

	return $html;
}
add_filter('metaslider_image_flex_slider_markup', 'vantage_metaslider_filter_flex_slide', 10, 3);