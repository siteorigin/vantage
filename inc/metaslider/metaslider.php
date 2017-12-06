<?php
/**
 * Tight integration with Meta Slider
 */


if( !function_exists('siteorigin_metaslider_get_options') ) :
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
endif;


if( !function_exists('siteorigin_metaslider_install_link') ) :
function siteorigin_metaslider_install_link(){
	if( function_exists('siteorigin_plugin_activation_install_url') ) {
		return siteorigin_plugin_activation_install_url('ml-slider', 'MetaSlider');
	}
	else {
		return 'http://downloads.wordpress.org/plugin/ml-slider.zip';
	}
}
endif;

if( !function_exists('siteorigin_metaslider_affiliate') ) :
function siteorigin_metaslider_affiliate(){
	return 'https://getdpd.com/cart/hoplink/15318?referrer=2h2i49ktlxic4s4osog';
}
endif;
add_filter('metaslider_hoplink', 'siteorigin_metaslider_affiliate');