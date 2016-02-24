<?php

function siteorigin_metaslider_layout_basic_right($layouts){
	$layouts['basic-right'] = array(
		'title' => __('Basic Right', 'siteorigin'),
		'html' =>
			siteorigin_metaslider_layer(
				'<h2><span style="font-size: 2.75em; color: #FFFFFF">'.__('This Is The First Line', 'siteorigin').'<br/><span style="font-weight:300">'.__('This is The Second', 'siteorigin').'</span></span></h2>',
				array(),
				array('top' => '{height:25%}', 'right' => 25),
				array('height' => 90, 'width' => '{width:50%}'),
				array('type' => 'fadeInRightBig', 'delay' => 0.5)
			).
			siteorigin_metaslider_layer(
				'<p class="siteorigin-slider-action-button"><a href="#"><span>'.__('An Action Button', 'siteorigin').'</span></a></p>',
				array(),
				array('bottom' => '{height:35%}', 'right' => 25),
				array('height' => 50, 'width' => '{width:50%}'),
				array('type' => 'fadeInRightBig', 'delay' => 0.75)
			).
			siteorigin_metaslider_layer(
				'<img src="'.get_template_directory_uri().'/extras/metaslider/img/portrait.jpg" style="max-width: 100%; height: auto;" width="320" height="380" />',
				array(),
				array('top' => '{height:10%}', 'left' => 25),
				array('height' => '{height:90%}', 'width' => 320),
				array('type' => 'fadeInUpBig', 'delay' => 1.5)
			)
	);
	return $layouts;
}
add_filter('siteorigin_metaslider_layouts', 'siteorigin_metaslider_layout_basic_right');