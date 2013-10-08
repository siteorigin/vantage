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
	$layouts['default-home'] = array (
		'name' => __('Default Home', 'vantage'),
		'widgets' =>
		array(
			0 =>
			array(
				'title' => __('Editable Home Page','vantage'),
				'text' => __("You can edit this home page using our free, drag and drop Page Builder, or simply disable it to fall back to a standard blog. It's a powerful page building experience.",'vantage'),
				'icon' => 'icon-edit',
				'image' => '',
				'icon_position' => 'top',
				'more' => __('Start Editing','vantage'),
				'more_url' => '#',
				'box' => false,
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
				'title' => __('Loads of Icons', 'vantage'),
				'text' => __('This widget uses FontAwesome - giving you hundreds of icons. Or you could disable the icon and use your own image image. Great for testimonials.','vantage'),
				'icon' => 'icon-ok-circle',
				'image' => '',
				'icon_position' => 'top',
				'more' => __('Example Button','vantage'),
				'more_url' => '#',
				'box' => false,
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
				'title' => __('Saves You Time','vantage'),
				'text' => __("Building your pages using a drag and drop page builder is a great experience that will save you time. Time is valuable. Don't waste it.",'vantage'),
				'icon' => 'icon-time',
				'image' => '',
				'icon_position' => 'top',
				'more' => __('Test Button','vantage'),
				'more_url' => '#',
				'box' => false,
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
				'headline' => __('This Is A Headline Widget','vantage'),
				'sub_headline' => __('You can customize it and put it where ever you want','vantage'),
				'info' =>
				array(
					'class' => 'Vantage_Headline_Widget',
					'id' => '4',
					'grid' => '1',
					'cell' => '0',
				),
			),
			4 =>
			array(
				'title' => __('Latest Posts', 'vantage'),
				'template' => 'loops/loop-carousel.php',
				'post_type' => 'post',
				'posts_per_page' => '4',
				'orderby' => 'date',
				'order' => 'DESC',
				'sticky' => '',
				'additional' => '',
				'info' =>
				array(
					'class' => 'SiteOrigin_Panels_Widgets_PostLoop',
					'id' => '5',
					'grid' => '2',
					'cell' => '0',
				),
			),
			5 =>
			array(
				'title' => '',
				'text' => __('There are a lot of widgets bundled with Page Builder. You can use them to bring your pages to life.','vantage'),
				'filter' => true,
				'info' =>
				array(
					'class' => 'WP_Widget_Text',
					'id' => '7',
					'grid' => '2',
					'cell' => '1',
				),
			),
		),
		'grids' =>
		array(
			0 =>
			array(
				'cells' => '3',
				'style' => '',
			),
			1 =>
			array(
				'cells' => '1',
				'style' => 'wide-grey',
			),
			2 =>
			array(
				'cells' => '2',
				'style' => '',
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
				'weight' => '1',
				'grid' => '1',
			),
			4 =>
			array(
				'weight' => '0.6658461538461539',
				'grid' => '2',
			),
			5 =>
			array(
				'weight' => '0.33415384615384613',
				'grid' => '2',
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
	$settings['responsive'] = siteorigin_setting( 'layout_responsive' );
	return $settings;
}
add_filter('siteorigin_panels_settings', 'vantage_panels_settings');

/**
 * Add row styles.
 *
 * @param $styles
 * @return mixed
 */
function vantage_panels_row_styles($styles) {
	$styles['wide-grey'] = __('Wide Grey', 'vantage');
	return $styles;
}
add_filter('siteorigin_panels_row_styles', 'vantage_panels_row_styles');