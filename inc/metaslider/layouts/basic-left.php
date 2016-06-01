<?php
if( !function_exists('siteorigin_metaslider_layout_basic_left') ) :
function siteorigin_metaslider_layout_basic_left($layouts){

	$layouts['basic-left'] = array(
		'title' => __('Basic Left', 'siteorigin'),
		'html' =>
			siteorigin_metaslider_layer(
				'<h2><span style="font-size: 2.75em; color: #FFFFFF">'.__('This Is The First Line', 'siteorigin').'<br/><span style="font-weight:300">'.__('This is The Second', 'siteorigin').'</span></span></h2>',
				array(),
				array('top' => '{height:25%}', 'left' => 25),
				array('height' => 90, 'width' => '{width:50%}'),
				array('type' => 'fadeInLeftBig', 'delay' => 0.5)
			).
			siteorigin_metaslider_layer(
				'<p class="siteorigin-slider-action-button"><a href="#"><span>'.__('An Action Button', 'siteorigin').'</span></a></p>',
				array(),
				array('bottom' => '{height:35%}', 'left' => 25),
				array('height' => 50, 'width' => '{width:50%}'),
				array('type' => 'fadeInLeftBig', 'delay' => 0.75)
			).
			siteorigin_metaslider_layer(
				'<p><img src="'.get_template_directory_uri().'/extras/metaslider/img/portrait.jpg" style="max-width: 100%; height: auto;" width="320" height="380" /></p>',
				array(),
				array('top' => '{height:10%}', 'right' => 25),
				array('height' => '{height:90%}', 'width' => 320),
				array('type' => 'fadeInUpBig', 'delay' => 1.5)
			)
	);
	return $layouts;
}
endif;
add_filter('siteorigin_metaslider_layouts', 'siteorigin_metaslider_layout_basic_left');
