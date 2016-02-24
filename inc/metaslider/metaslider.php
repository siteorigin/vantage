<?php
/**
 * Tight integration with Meta Slider
 */

/**
 * Enqueue scripts and styles for meta slider
 */
function siteorigin_metaslider_register_admin_scripts(){
	wp_enqueue_script('siteorigin-metaslider', get_template_directory_uri().'/extras/metaslider/js/metaslider.js',  array('jquery', 'media-views', 'metaslider-admin-script'), SITEORIGIN_THEME_VERSION);
	wp_enqueue_style('siteorigin-metaslider', get_template_directory_uri().'/extras/metaslider/css/metaslider.css',  array(), SITEORIGIN_THEME_VERSION);
	wp_localize_script('siteorigin-metaslider', 'siteoriginMetaslider', array(
		'prebuilt' => __('Prebuilt Slide Layouts', 'vantage'),
		'replace' => __('Are you sure you want to replace your current slide content with this prebuilt layout?', 'vantage')
	) );

	// Check if this theme has a metaslider editor style
	if(file_exists(get_template_directory().'/slider/metaslider-editor-style.css')) {
		wp_enqueue_style('siteorigin-metaslider-editor-style', get_template_directory_uri().'/slider/metaslider-editor-style.css',  array(), SITEORIGIN_THEME_VERSION);
	}
}
add_action('metaslider_register_admin_scripts', 'siteorigin_metaslider_register_admin_scripts');

/**
 *
 */
function siteorigin_metaslider_prebuilt_window(){
	if(isset($_GET['page']) && $_GET['page'] == 'metaslider') {
		$layouts = siteorigin_metaslider_prebuilt_layouts();

		?>
		<div id="siteorigin-metaslider-prebuilt-layouts-overlay"></div>
		<div id="siteorigin-metaslider-prebuilt-layouts">
			<a href="#" class="close">x</a>
			<h2><?php _e('Prebuilt Layouts', 'vantage') ?></h2>

			<ul class="layouts">
				<?php foreach($layouts as $id => $layout) : ?>
					<li class="layout" data-html="<?php echo esc_attr($layout['html']) ?>">
						<img src="<?php echo get_template_directory_uri().'/extras/metaslider/img/layouts/'.$id.'.png' ?>" />
						<h4><?php echo $layout['title'] ?></h4>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}
}
add_action('admin_footer', 'siteorigin_metaslider_prebuilt_window');

/**
 * @return mixed|void
 */
function siteorigin_metaslider_prebuilt_layouts(){
	static $layouts = null;
	if(is_null($layouts)){
		do_action('siteorigin_metaslider_load_prebuilt_layout_files');
		foreach( glob(dirname(__FILE__).'/layouts/*.php') as $lf ) {
			include_once($lf);
		}

		$layouts = apply_filters('siteorigin_metaslider_layouts', array());
	}

	return $layouts;
}

function siteorigin_metaslider_get_options($has_demo = true){
	$options = array( '' => __('None', 'vantage') );

	if($has_demo) $options['demo'] = __('Demo Slider', 'vantage');

	if(class_exists('MetaSliderPlugin')){
		$sliders = get_posts(array(
			'post_type' => 'ml-slider',
			'numberposts' => 200,

		));

		foreach($sliders as $slider) {
			$options[ 'meta:' . $slider->ID ] = __('Slider: ', 'vantage') . $slider->post_title;
		}
	}

	return $options;
}

function siteorigin_metaslider_install_link(){
	if( function_exists('siteorigin_plugin_activation_install_url') ) {
		return siteorigin_plugin_activation_install_url('ml-slider', 'MetaSlider');
	}
	else {
		return 'http://downloads.wordpress.org/plugin/ml-slider.zip';
	}
}

function siteorigin_metaslider_affiliate(){
	return 'https://getdpd.com/cart/hoplink/15318?referrer=2h2i49ktlxic4s4osog';
}
add_filter('metaslider_hoplink', 'siteorigin_metaslider_affiliate');

/**
 * Create the HTML for a slider layer.
 *
 * @param $content
 * @param $position
 * @param $size
 * @param $animate_in
 * @param $animate_out
 */
function siteorigin_metaslider_layer($content, $layer_style, $position, $size, $animate_in = array(), $animate_out = array()){
	ob_start();

	// The layer HTML
	$style = array(
		'position: absolute',
		'width: '.$size['width'].'px',
		'height: '.$size['height'].'px',
	);
	$data_position = array();

	foreach(array('top', 'left', 'right', 'bottom') as $p) {
		if(isset($position[$p])) {
			$style[] = $p.': '.$position[$p].'px';
			$data_position[] = 'data-'.$p.'="'.$position[$p].'"';
		}
	}

	if(isset($animate_in['delay'])) {
		$animate_in_delay_style = 'animation-delay: ' . ($animate_in['delay'] * 1000) . 'ms';
		$animate_in_delay_style = "$animate_in_delay_style; -webkit-$animate_in_delay_style; -moz-$animate_in_delay_style;";
	}

	if(isset($animate_out['delay'])) {
		$animate_out_delay_style = 'animation-delay: ' . ($animate_out['delay'] * 1000) . 'ms';
		$animate_out_delay_style = "$animate_out_delay_style; -webkit-$animate_out_delay_style; -moz-$animate_out_delay_style;";
	}

	?>
	<div class="layer siteorigin-slide-layer" data-width="<?php echo esc_attr($size['width']) ?>" data-height="<?php echo esc_attr($size['height']) ?>" style="<?php echo esc_attr( implode('; ', $style) ) ?>" <?php echo implode(' ', $data_position) ?>>
		<div class="animation_in animated <?php echo isset($animate_in['type']) ? esc_attr($animate_in['type']) : 'disabled' ?>" data-animation="<?php echo isset($animate_in['type']) ? esc_attr($animate_in['type']) : 'disabled' ?>" data-animation-delay="<?php echo isset($animate_in['delay']) ? intval($animate_in['delay']) : 0 ?>" style="width: 100%; height: 100%; <?php if(!empty($animate_in_delay_style)) echo $animate_in_delay_style ?>">
			<div class="animation_out animated <?php echo isset($animate_out['type']) ? esc_attr($animate_out['type']) : 'disabled' ?>" data-animation="<?php echo isset($animate_in['type']) ? esc_attr($animate_in['type']) : 'disabled' ?>" data-animation-delay="<?php echo isset($animate_out['delay']) ? intval($animate_out['delay']) : 0 ?>" style="height: 100%; width: 100%; <?php if(!empty($animate_out_delay_style)) echo $animate_out_delay_style ?>">
				<div class="content_wrap" style="height: 100%;">
					<div class="content" id="layer_content_{rand}" data-padding="<?php echo isset($layer_style['padding']) ? intval($layer_style['padding']) : 0 ?>" style="<?php foreach($layer_style as $a => $v) echo $a.': '.$v ?>">
						<?php echo $content ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php

	return ob_get_clean();
}