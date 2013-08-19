<?php

/* Handle the nav menu icon */

function vantage_filter_nav_menu_items($item_output, $item, $depth, $args){

	$object_type = get_post_meta($item->ID, '_menu_item_object', true);
	if($object_type == 'page') {
		$object_id = get_post_meta($item->ID, '_menu_item_object_id', true);
		$icon = get_post_meta($object_id, 'vantage_menu_icon', true);

		if(!empty($icon)) {
			$item_output = str_replace('<span class="icon"></span>', '<span class="'.esc_attr($icon).'"></span>', $item_output);
		}
		else {
			$item_output = str_replace('<span class="icon"></span>', '', $item_output);
		}
	}
	else {
		$item_output = str_replace('<span class="icon"></span>', '', $item_output);
	}


	return $item_output;
}
add_filter('walker_nav_menu_start_el', 'vantage_filter_nav_menu_items', 10, 4);

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

function vantage_menu_icon_metabox_render($post){
	$icons = include (get_template_directory().'/fontawesome/icons.php');
	$sections = include (get_template_directory().'/fontawesome/icon-sections.php');
	$current = get_post_meta($post->ID, 'vantage_menu_icon', true);

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

function vantage_icon_get_name($icon){
	$name = str_replace('icon-', '', $icon);
	$name = str_replace('-', ' ', $name);
	$name = ucwords($name);
	return $name;
}

function vantage_menu_icon_save($post_id){
	if(empty($_POST['_vantage_menuicon_nonce']) || !wp_verify_nonce($_POST['_vantage_menuicon_nonce'], 'save_post_icon')) return;
	if(!current_user_can('edit_post', $post_id));
	update_post_meta($post_id, 'vantage_menu_icon', $_POST['vantage_menu_icon']);
}
add_action('save_post', 'vantage_menu_icon_save');