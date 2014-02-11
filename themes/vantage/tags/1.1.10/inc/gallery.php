<?php
/**
 * Adds some functionality to theme galleries
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */


/**
 * Display a flex slider powered gallery.
 *
 * @param $contents
 * @param $atts
 * @return string
 */
function vantage_gallery($contents, $attr){
	if(empty($attr['type']) || $attr['type'] != 'slider') return;
	
	global $post;

	static $instance = 0;
	$instance++;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	/**
	 * @var $order
	 * @var $orderby
	 * @var $id
	 * @var $itemtag
	 * @var $icontag
	 * @var $captiontag
	 * @var $size
	 * @var $include
	 * @var $exclude
	 * @var $wp_default
	 * @var $target_blank
	 */
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'large',
		'include'    => '',
		'exclude'    => '',
		'wp_default'    => false,
		'target_blank' => false,
	), $attr));

	// This gallery has requested to use the WordPress default gallery
	if($wp_default) return $contents;

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	}
	elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}
	else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) ) return '';

	// This is the custom stuff

	// Create the gallery content
	$return = '';
	$return .= '<div class="flexslider-wrapper">';
	$return .= '<div class="flexslider">';
	$return .= '<ul class="slides">';
	foreach($attachments as $attachment){
		$return .= '<li>';
		$return .= apply_filters('vantage_slide_before', '', $attachment);
		$return .= wp_get_attachment_image($attachment->ID, $size, false, array('class' => 'slide-image'));
		if($attachment->post_excerpt){
			$return .= '<div class="flex-caption">' . $attachment->post_excerpt . '</div>';
		}
		$return .= apply_filters('vantage_slide_after', '', $attachment);
		$return .= '</li>';
	}
	$return .= '</ul>';
	$return .= '</div>';
	$return .= '</div>';

	return $return;
}
add_filter('post_gallery', 'vantage_gallery', 10, 2);

/**
 * Add our fancy slider gallery to the list of gallery types.
 * 
 * @param $types
 * @return mixed
 * 
 * @since vantage 1.0
 */
function vantage_gallery_types($types){
	$types['slider'] = __('Slider', 'vantage');
	return $types;
}
add_filter('siteorigin_gallery_types', 'vantage_gallery_types');

/**
 * Set our fancy gallery to the default gallery type.
 *
 * @param $types
 * @return mixed
 * 
 * @since vantage 1.0
 */
function vantage_gallery_default_type(){
	return 'slider';
}
add_filter('siteorigin_gallery_default_type', 'vantage_gallery_default_type');