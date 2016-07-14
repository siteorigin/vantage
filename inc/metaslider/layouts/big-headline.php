<?php
if( !function_exists('siteorigin_metaslider_layout_big_headline') ) :
function siteorigin_metaslider_layout_big_headline($layouts){
	$layouts['big-headline'] = array(
		'title' => __('Big Headline', 'siteorigin'),
		'html' =>
			siteorigin_metaslider_layer(
				'<h2><span style="font-size: 2.75em; color: #FFFFFF; text-align: center">'.__('This Is The First Line', 'siteorigin').'<br/><span style="font-weight:300">'.__('This is The Second', 'siteorigin').'</span></span></h2>',
				array('text-align' => 'center'),
				array('top' => 25, 'left' => 0),
				array('height' => 90, 'width' => '{width:100%}'),
				array('type' => 'fadeInDownBig', 'delay' => 0.5)
			).
			siteorigin_metaslider_layer(
				'<p class="siteorigin-slider-action-button"><a href="#"><span>'.__('An Action Button', 'siteorigin').'</span></a></p>',
				array('text-align' => 'center'),
				array('top' => 140, 'left' => 0),
				array('height' => 50, 'width' => '{width:100%}'),
				array('type' => 'fadeInDownBig', 'delay' => 0.75)
			).
			siteorigin_metaslider_layer(
				'<p><img src="'.get_template_directory_uri().'/extras/metaslider/img/landscape.jpg" style="max-width: 100%; height: auto;" width="480" height="280" /></p>',
				array('text-align' => 'center'),
				array('bottom' => 0, 'right' => 0),
				array('height' => '{height:50%}', 'width' => '{width:100%}'),
				array('type' => 'fadeIn', 'delay' => 1.5)
			)
	);
	return $layouts;
}
endif;
add_filter('siteorigin_metaslider_layouts', 'siteorigin_metaslider_layout_big_headline');
