<?php
/**
 * Integrates this theme with SiteOrigin Page Builder.
 * 
 * @package vantage
 * @since 1.0
 * @license GPL 2.0
 */

/**
 * Adds default page layouts
 *
 * @param $layouts
 */
function vantage_prebuilt_page_layouts($layouts){

	$layouts['default-home'] = array(
		'name' => __('Standard Home Page', 'vantage'),
		'widgets' =>
		array(
			0 =>
			array(
				'title' => 'Some Headline',
				'text' => 'Maecenas sed dignissim turpis, sed feugiat elit. Duis ullamcorper posuere purus non mattis. Maecenas semper odio odio, et interdum eros consectetur nec. Sed molestie pharetra ipsum.',
				'image' => 'http://dev.localhost/wp-content/themes/vantage/images/demo/rocket.png',
				'icon_position' => 'top',
				'more' => '',
				'more_url' => '#',
				'info' =>
				array(
					'class' => 'Vantage_CircleIcon_Widget',
					'id' => '1',
					'grid' => '0',
					'cell' => '0',
				),
			),
			1 =>
			array(
				'title' => 'This is a test',
				'text' => 'Maecenas sed dignissim turpis, sed feugiat elit. Duis ullamcorper posuere purus non mattis. Maecenas semper odio odio, et interdum eros consectetur nec. Sed molestie pharetra ipsum.',
				'image' => 'http://dev.localhost/wp-content/themes/vantage/images/demo/dollar.png',
				'icon_position' => 'top',
				'more' => 'Contact Us',
				'more_url' => '#',
				'info' =>
				array(
					'class' => 'Vantage_CircleIcon_Widget',
					'id' => '2',
					'grid' => '0',
					'cell' => '1',
				),
			),
			2 =>
			array(
				'title' => 'Final Test Line',
				'text' => 'Maecenas sed dignissim turpis, sed feugiat elit. Duis ullamcorper posuere purus non mattis. Maecenas semper odio odio, et interdum eros consectetur nec. Sed molestie pharetra ipsum.',
				'image' => 'http://dev.localhost/wp-content/themes/vantage/images/demo/star.png',
				'icon_position' => 'top',
				'more' => 'Final',
				'more_url' => '#',
				'info' =>
				array(
					'class' => 'Vantage_CircleIcon_Widget',
					'id' => '3',
					'grid' => '0',
					'cell' => '2',
				),
			),
			3 =>
			array(
				'title' => 'Latest News',
				'template' => 'loop-carousel.php',
				'post_type' => 'post',
				'posts_per_page' => '2',
				'orderby' => 'date',
				'order' => 'DESC',
				'sticky' => '',
				'additional' => '',
				'info' =>
				array(
					'class' => 'SiteOrigin_Panels_Widgets_PostLoop',
					'id' => '5',
					'grid' => '1',
					'cell' => '1',
				),
			),
			4 =>
			array(
				'type' => 'visual',
				'title' => 'This is a title',
				'text' => '<p>Nullam purus dui, sollicitudin faucibus libero et, rhoncus vulputate tortor. In risus nulla, eleifend vel purus sed, mollis laoreet nisi. Suspendisse quis massa dolor. Sed sed sodales sem. Duis sit amet varius lectus. Mauris commodo vehicula cursus. Pellentesque id sollicitudin nibh, a lobortis sapien. Curabitur non nisl ultrices, fringilla nunc vel, imperdiet ante.</p>
<p>Suspendisse non libero vel urna tincidunt dapibus. Praesent commodo dolor vitae eleifend molestie. Morbi pretium, sapien a condimentum placerat, odio eros sollicitudin sapien, sed consequat est justo nec mi. Quisque ornare urna ut nisi tincidunt facilisis. Aliquam eget feugiat lectus. Duis tempor metus malesuada risus laoreet pharetra. Nam consequat purus dapibus felis vehicula, et lacinia orci elementum. In hac habitasse platea dictumst. Etiam libero purus, malesuada id venenatis ac, accumsan sodales nisl. Sed nec egestas magna. In feugiat augue et interdum pellentesque. Nullam laoreet, mi eget interdum auctor, ipsum diam ultricies lorem, aliquam pulvinar neque sapien sed turpis. Donec ac facilisis nulla. Pellentesque dignissim consectetur enim, consequat malesuada ipsum accumsan vitae. Proin egestas ante in velit fringilla, vel iaculis nunc viverra. Nunc ut volutpat ipsum, vitae blandit metus.</p>',
				'info' =>
				array(
					'class' => 'WP_Widget_Black_Studio_TinyMCE',
					'id' => '6',
					'grid' => '1',
					'cell' => '1',
				),
			),
		),
		'grids' =>
		array(
			0 =>
			array(
				'cells' => '3',
			),
			1 =>
			array(
				'cells' => '2',
			),
		),
		'grid_cells' =>
		array(
			0 =>
			array(
				'weight' => '0.3333333333333333',
				'grid' => '0',
			),
			1 =>
			array(
				'weight' => '0.3333333333333333',
				'grid' => '0',
			),
			2 =>
			array(
				'weight' => '0.3333333333333333',
				'grid' => '0',
			),
			3 =>
			array(
				'weight' => 0.33333,
				'grid' => '1',
			),
			4 =>
			array(
				'weight' => 0.66666,
				'grid' => '1',
			),
		),
	);

	return $layouts;
}
add_filter('siteorigin_panels_prebuilt_layouts', 'vantage_prebuilt_page_layouts');

/**
 * Configure the SiteOrigin page builder settings.
 * 
 * @param $settings
 * @return mixed
 */
function vantage_panels_settings($settings){
	$settings['home-page'] = true;
	$settings['margin-bottom'] = 35;
	$settings['home-page-default'] = 'default-home';
	return $settings;
}
add_filter('siteorigin_panels_settings', 'vantage_panels_settings');

function vantage_panels_row_styles($styles) {
	$styles['wide-grey'] = __('Wide Grey', 'vantage');
	return $styles;
}
add_filter('siteorigin_panels_row_styles', 'vantage_panels_row_styles');