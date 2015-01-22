<?php

/* Handle the nav menu icon */

function vantage_filter_nav_menu_items($item_output, $item, $depth, $args){
	$object_type = get_post_meta($item->ID, '_menu_item_object', true);

	if($object_type == 'page') {
		$object_id = get_post_meta($item->ID, '_menu_item_object_id', true);
		$icon = get_post_meta($object_id, 'vantage_menu_icon', true);

		if(!empty($icon)) {
			$icon = apply_filters('vantage_fontawesome_icon_name', $icon );
			$item_output = str_replace( '<span class="icon"></span>', '<span class="' . esc_attr( $icon ) . '"></span>', $item_output );
		}
		else {
			$item_output = str_replace('<span class="icon"></span>', '', $item_output);
		}
	}
	elseif($object_type == 'custom') {
		if( siteorigin_setting('navigation_home_icon') && strpos($item_output, 'href="'.home_url('/').'"', 0) !== false ) {
			$item_output = str_replace('<span class="icon"></span>', '<span class="fa fa-home"></span>', $item_output);
		}
	}
	else {
		$item_output = str_replace('<span class="icon"></span>', '', $item_output);
	}


	return $item_output;
}
add_filter('walker_nav_menu_start_el', 'vantage_filter_nav_menu_items', 10, 4);

/**
 * Add the metabox for menu icon.
 */
function vantage_menu_icon_metabox(){
	add_meta_box(
		'vantage-menu-icon-metabox',
		__( 'Menu Icon', 'vantage' ),
		'vantage_menu_icon_metabox_render',
		'page',
		'side'
	);
}
add_action('add_meta_boxes', 'vantage_menu_icon_metabox');

/**
 * @param $post
 */
function vantage_menu_icon_metabox_render($post){
	$icons = include (get_template_directory().'/fontawesome/icons.php');
	$sections = include (get_template_directory().'/fontawesome/icon-sections.php');
	$current = get_post_meta($post->ID, 'vantage_menu_icon', true);
	if(!empty($current)) {
		$current = apply_filters('vantage_fontawesome_icon_name', $current );
	}

	?>
	<select name="vantage_menu_icon">
		<option value="" <?php selected($current) ?>><?php esc_html_e('None', 'vantage') ?></option>
		<?php foreach($icons as $section => $s_icons) : ?>
			<?php if(isset($sections[$section])) : ?><optgroup label="<?php echo esc_attr($sections[$section]) ?>"><?php endif; ?>
				<?php foreach($s_icons as $icon) : ?>
					<option value="<?php echo esc_attr($icon) ?>" <?php selected($current, $icon) ?>><?php echo esc_html(vantage_icon_get_name($icon)) ?></option>
				<?php endforeach; ?>
			</optgroup>
		<?php endforeach; ?>
	</select>
	<?php
	wp_nonce_field('save_post_icon', '_vantage_menuicon_nonce');
}

/**
 * @param $icon
 * @return string
 */
function vantage_icon_get_name($icon){
	$name = preg_replace('/^icon-/', '', $icon);
	$name = preg_replace('/^fa fa-/', '', $name);
	$name = str_replace('-', ' ', $name);
	$name = ucwords($name);
	return $name;
}

/**
 * Save tge post icon setting
 *
 * @param $post_id
 */
function vantage_menu_icon_save($post_id){
	if(empty($_POST['_vantage_menuicon_nonce']) || !wp_verify_nonce($_POST['_vantage_menuicon_nonce'], 'save_post_icon')) return;
	if(!current_user_can('edit_post', $post_id));
	update_post_meta($post_id, 'vantage_menu_icon', $_POST['vantage_menu_icon']);
}
add_action('save_post', 'vantage_menu_icon_save');