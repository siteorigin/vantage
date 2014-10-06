<?php

function vantage_settings_tour($tour){
	$tour = array();

	$tour[] = array(
		'title' => __( 'Upload Your Logo', 'vantage' ),
		'content' => __( 'Aliquam efficitur felis a odio facilisis, at feugiat erat molestie. Nulla tristique odio ut est dignissim posuere. Cras non nibh non ante eleifend lacinia. Phasellus tempus, justo vitae convallis tincidunt, ex felis blandit nunc, quis bibendum nibh augue in ligula. Mauris at mauris vitae quam egestas aliquet. Integer id posuere lorem. Ut quis interdum urna.', 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/step-logo.png',
		'setting' => 'logo_image',
		'video' => 102103379,
	);

	$tour[] = array(
		'title' => __( 'Upload Your Retina Logo', 'vantage' ),
		'content' => __( 'Nunc pellentesque est nisi, eget viverra sem lobortis quis. Aliquam vel ligula in tortor tincidunt laoreet. Vivamus porttitor lorem id lorem vehicula porttitor. Sed posuere nibh nec enim fermentum, ut lobortis turpis congue. In pellentesque orci sed enim mattis, eu aliquam tellus tincidunt.', 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/step-logo.png',
		'setting' => 'logo_image_retina',
		'video' => 102103379,
	);

	$tour[] = array(
		'title' => __( 'Change The Header Text', 'vantage' ),
		'content' => __( 'Nunc pellentesque est nisi, eget viverra sem lobortis quis. Aliquam vel ligula in tortor tincidunt laoreet. Vivamus porttitor lorem id lorem vehicula porttitor. Sed posuere nibh nec enim fermentum, ut lobortis turpis congue. In pellentesque orci sed enim mattis, eu aliquam tellus tincidunt.', 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/step-logo.png',
		'setting' => 'logo_header_text',
		'video' => 102103379,
	);

	$tour[] = array(
		'title' => __( 'Choose Your Layout', 'vantage' ),
		'content' => __( 'Nunc pellentesque est nisi, eget viverra sem lobortis quis. Aliquam vel ligula in tortor tincidunt laoreet. Vivamus porttitor lorem id lorem vehicula porttitor. Sed posuere nibh nec enim fermentum, ut lobortis turpis congue. In pellentesque orci sed enim mattis, eu aliquam tellus tincidunt.', 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/step-logo.png',
		'setting' => 'layout_bound',
		'video' => 102103379,
	);

	return $tour;
}
add_filter('siteorigin_settings_tour_content', 'vantage_settings_tour');