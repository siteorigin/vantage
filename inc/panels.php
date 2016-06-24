<?php
/**
 * Integrates this theme with SiteOrigin Page Builder.
 *
 * @package vantage
 * @since 1.0
 * @license GPL 2.0
 */

if( !function_exists('vantage_prebuilt_page_layouts') ) :
/**
 * Adds default page layouts
 *
 * @param $layouts
 */
function vantage_prebuilt_page_layouts($layouts){
	$layouts['default-home'] = array (
		'name' => __('Default Home', 'vantage'),
		'screenshot' =>  get_template_directory_uri() . '/images/default-home.png',
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
				'style' => array(
					'class' => 'wide-grey'
				),
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
endif;
add_filter('siteorigin_panels_prebuilt_layouts', 'vantage_prebuilt_page_layouts');

if( !function_exists('vantage_panels_row_styles') ) :
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
endif;
add_filter('siteorigin_panels_row_styles', 'vantage_panels_row_styles');

if( !function_exists('vantage_panels_save_post') ) :
function vantage_panels_save_post( $post_id, $post ){
	if( get_post_meta( $post_id, 'vantage_panels_no_legacy', true ) === '' ) {

		if( get_post_meta( $post_id, 'panels_data', true ) === '' ) {
			// There is no panels_data, so don't use legacy fields
			add_post_meta( $post_id, 'vantage_panels_no_legacy', 'true', true );
		}
		else {
			// There is existing panels_data, so add legacy fields
			add_post_meta( $post_id, 'vantage_panels_no_legacy', 'false', true );
		}

	}

}
endif;
add_action('save_post', 'vantage_panels_save_post', 5, 2);

if( !function_exists('vantage_panels_row_style_fields') ) :
function vantage_panels_row_style_fields($fields) {
	if(
		( !empty($_REQUEST['postId']) && get_post_meta( intval( $_REQUEST['postId'] ), 'vantage_panels_no_legacy', true ) === 'true' ) ||
		( get_the_ID() && get_post_meta( get_the_ID(), 'vantage_panels_no_legacy', true ) === 'true' )
	) {
		return $fields;
	}

	$fields['top_border'] = array(
		'name' => __('Top Border Color', 'vantage'),
		'priority' => 3,
		'group' => 'theme',
		'type' => 'color',
	);

	$fields['bottom_border'] = array(
		'name' => __('Bottom Border Color', 'vantage'),
		'priority' => 3,
		'group' => 'theme',
		'type' => 'color',
	);

	$fields['background'] = array(
		'name' => __('Background Color', 'vantage'),
		'priority' => 5,
		'group' => 'theme',
		'type' => 'color',
	);

	$fields['background_image'] = array(
		'name' => __('Background Image URL', 'vantage'),
		'priority' => 6,
		'group' => 'theme',
		'type' => 'url',
	);

	$fields['background_image_repeat'] = array(
		'name' => __('Repeat Background Image', 'vantage'),
		'priority' => 7,
		'group' => 'theme',
		'type' => 'checkbox',
	);

	$fields['no_margin'] = array(
		'name' => __('No Bottom Margin', 'vantage'),
		'priority' => 10,
		'group' => 'theme',
		'type' => 'checkbox',
	);

	// How we also need to remove some of the fields implemented by Page Builder 2 that aren't compatible.
	unset( $fields['background_image_attachment'] );
	unset( $fields['background_display'] );
	unset( $fields['border_color'] );

	return $fields;
}
endif;
add_filter('siteorigin_panels_row_style_fields', 'vantage_panels_row_style_fields', 11);

if( !function_exists('vantage_panels_panels_row_style_attributes') ) :
function vantage_panels_panels_row_style_attributes($attr, $style) {
	if(empty($attr['style'])) $attr['style'] = '';

	if(!empty($style['top_border'])) $attr['style'] .= 'border-top: 1px solid '.esc_attr($style['top_border']).'; ';
	if(!empty($style['bottom_border'])) $attr['style'] .= 'border-bottom: 1px solid '.esc_attr($style['bottom_border']).'; ';
	if(!empty($style['background'])) $attr['style'] .= 'background-color: '.esc_attr($style['background']).'; ';
	if(!empty($style['background_image'])) $attr['style'] .= 'background-image: url('.esc_url($style['background_image']).'); ';
	if(!empty($style['background_image_repeat'])) $attr['style'] .= 'background-repeat: repeat; ';

	if( isset($style['row_stretch']) && strpos($style['row_stretch'], 'full') !== false ) {
		// We'll use this to prevent the jump when loading.
		$attr['class'][] = 'panel-row-style-full-width';
	}

	if( isset($style['class']) && $style['class'] == 'wide-grey' && siteorigin_setting( 'layout_bound' ) == 'full' ) {
		$attr['style'] .= 'padding-left: 1000px; padding-right: 1000px;';
	}

	if( empty($attr['style']) ) unset( $attr['style'] );
	return $attr;
}
endif;
add_filter('siteorigin_panels_row_style_attributes', 'vantage_panels_panels_row_style_attributes', 10, 2);

if( !function_exists('vantage_panels_panels_row_attributes') ) :
function vantage_panels_panels_row_attributes($attr, $row) {
	if(!empty($row['style']['no_margin'])) {
		if(empty($attr['style'])) $attr['style'] = '';
		$attr['style'] .= 'margin-bottom: 0px;';
	}

	return $attr;
}
endif;
add_filter('siteorigin_panels_row_attributes', 'vantage_panels_panels_row_attributes', 10, 2);

if( !function_exists('vantage_panels_add_widget_groups') ) :
/**
 * Set the groups for all Vantage registered Widgets
 *
 * @param $widgets
 *
 * @return mixed
 */
function vantage_panels_add_widget_groups($widgets){
	$widgets['Vantage_CircleIcon_Widget']['groups'] = array('vantage');
	$widgets['Vantage_Headline_Widget']['groups'] = array('vantage');
	$widgets['Vantage_Social_Media_Widget']['groups'] = array('vantage');
	return $widgets;

}
endif;
add_filter('siteorigin_panels_widgets', 'vantage_panels_add_widget_groups');

if( !function_exists('vantage_panels_add_widgets_dialog_tabs') ) :
function vantage_panels_add_widgets_dialog_tabs($tabs){
	$tabs[] = array(
		'title' => __('Vantage Widgets', 'vantage'),
		'filter' => array(
			'installed' => true,
			'groups' => array('vantage')
		)
	);

	return $tabs;
}
endif;
add_filter('siteorigin_panels_widget_dialog_tabs', 'vantage_panels_add_widgets_dialog_tabs');

if( !function_exists('vantage_panels_add_full_width_container') ) :
function vantage_panels_add_full_width_container(){
	return '#main';
}
endif;
add_filter('siteorigin_panels_full_width_container', 'vantage_panels_add_full_width_container');
