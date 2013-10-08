<?php
/**
 * Give this theme some additional widgets.
 *
 * @package vantage
 * @since 1.0
 * @license GPL 2.0
 */

class Vantage_CircleIcon_Widget extends WP_Widget {

	public function __construct() {
		// widget actual processes
		parent::__construct(
			'circleicon-widget', // Base ID
			__('Circle Icon', 'vantage'), // Name
			array( 'description' => __( 'An icon in a circle with some text beneath it', 'vantage' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		$instance = wp_parse_args( $instance, array(
			'title' => '',
			'text' => '',
			'icon' => '',
			'image' => '',
			'icon_position' => 'top',
			'icon_size' => 'small',
			'icon_background_color' => '',
			'more' => '',
			'more_url' => '',
			'all_linkable' => false,
			'box' => false,
		) );

		$icon_styles = array();
		if(!empty($instance['image'])) {
			$icon_styles[] = 'background-image: url('.esc_url($instance['image']).')';
		}
		if( !empty($instance['icon_background_color']) && preg_match('/^#?+[0-9a-f]{3}(?:[0-9a-f]{3})?$/i', $instance['icon_background_color'])) {
			$icon_styles[] = 'background-color: '.$instance['icon_background_color'];
		}


		?>
		<div class="circle-icon-box icon-position-<?php echo esc_attr($instance['icon_position']) ?> <?php echo empty($instance['box']) ? 'circle-icon-hide-box' : 'circle-icon-show-box' ?> circle-icon-size-<?php echo $instance['icon_size'] ?>">
			<div class="circle-icon-wrapper">
                <?php if(!empty($instance['more_url']) && !empty($instance['all_linkable'])) : ?><a href="<?php echo esc_url($instance['more_url']) ?>" class="link-icon"><?php endif; ?>
				<div class="circle-icon" <?php if(!empty($icon_styles)) echo 'style="'.implode(';', $icon_styles).'"' ?>>
					<?php if(!empty($instance['icon'])) : ?><div class="<?php echo esc_attr($instance['icon']) ?>"></div><?php endif; ?>
				</div>
                <?php if(!empty($instance['more_url']) && !empty($instance['all_linkable'])) : ?></a><?php endif; ?>
			</div>

            <?php if(!empty($instance['more_url']) && !empty($instance['all_linkable'])) : ?><a href="<?php echo esc_url($instance['more_url']) ?>" class="link-title"><?php endif; ?>
			<?php if(!empty($instance['title'])) : ?><h4><?php echo esc_html($instance['title']) ?></h4><?php endif; ?>
            <?php if(!empty($instance['more_url']) && !empty($instance['all_linkable'])) : ?></a><?php endif; ?>

			<?php if(!empty($instance['text'])) : ?><p class="text"><?php echo wp_kses_post($instance['text']) ?></p><?php endif; ?>
			<?php if(!empty($instance['more_url'])) : ?>
				<a href="<?php echo esc_url($instance['more_url']) ?>" class="more-button"><?php echo !empty($instance['more']) ? esc_html($instance['more']) : __('More Info', 'vantage') ?> <i></i></a>
			<?php endif; ?>
		</div>
		<?php

		echo $args['after_widget'];
	}

	/**
	 * Display the circle icon widget form.
	 *
	 * @param array $instance
	 * @return string|void
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( $instance, array(
			'title' => '',
			'text' => '',
			'icon' => '',
			'image' => '',
			'icon_position' => 'top',
			'icon_size' => 'small',
			'icon_background_color' => '',
			'more' => '',
			'more_url' => '',
			'all_linkable' => false,
			'box' => false,
		) );

		$icons = include ( get_template_directory() . '/fontawesome/icons.php' );
		$sections = include (get_template_directory().'/fontawesome/icon-sections.php');

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" value="<?php echo esc_attr($instance['title']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text') ?>"><?php _e('Text', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('text') ?>" name="<?php echo $this->get_field_name('text') ?>" value="<?php echo esc_attr($instance['text']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon') ?>"><?php _e('Icon', 'vantage') ?></label>
			<select id="<?php echo $this->get_field_id('icon') ?>" name="<?php echo $this->get_field_name('icon') ?>">
				<option value="" <?php selected(!empty($instance['icon'])) ?>><?php esc_html_e('None', 'vantage') ?></option>
				<?php foreach($icons as $section => $s_icons) : ?>
					<?php if(isset($sections[$section])) : ?><optgroup label="<?php echo esc_attr($sections[$section]) ?>"><?php endif; ?>
						<?php foreach($s_icons as $icon) : ?>
							<option value="<?php echo esc_attr($icon) ?>" <?php selected($instance['icon'], $icon) ?>><?php echo esc_html(vantage_icon_get_name($icon)) ?></option>
						<?php endforeach; ?>
					</optgroup>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_background_color') ?>"><?php _e('Icon Background Color', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('icon_background_color') ?>" name="<?php echo $this->get_field_name('icon_background_color') ?>" value="<?php echo esc_attr($instance['icon_background_color']) ?>" />
			<span class="description"><?php _e('A hex color', 'vantage'); ?></span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('image') ?>"><?php _e('Circle Background Image URL', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('image') ?>" name="<?php echo $this->get_field_name('image') ?>" value="<?php echo esc_attr($instance['image']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_position') ?>"><?php _e('Icon Position', 'vantage') ?></label>
			<select id="<?php echo $this->get_field_id('icon_position') ?>" name="<?php echo $this->get_field_name('icon_position') ?>">
				<option value="top" <?php selected('top', $instance['icon_position']) ?>><?php esc_html_e('Top', 'vantage') ?></option>
				<option value="bottom" <?php selected('bottom', $instance['icon_position']) ?>><?php esc_html_e('Bottom', 'vantage') ?></option>
				<option value="left" <?php selected('left', $instance['icon_position']) ?>><?php esc_html_e('Left', 'vantage') ?></option>
				<option value="right" <?php selected('right', $instance['icon_position']) ?>><?php esc_html_e('Right', 'vantage') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('icon_size') ?>"><?php _e('Icon Size', 'vantage') ?></label>
			<select id="<?php echo $this->get_field_id('icon_size') ?>" name="<?php echo $this->get_field_name('icon_size') ?>">
				<option value="small" <?php selected('small', $instance['icon_size']) ?>><?php esc_html_e('Small', 'vantage') ?></option>
				<option value="medium" <?php selected('medium', $instance['icon_size']) ?>><?php esc_html_e('Medium', 'vantage') ?></option>
				<option value="large" <?php selected('large', $instance['icon_size']) ?>><?php esc_html_e('Large', 'vantage') ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('more') ?>"><?php _e('More Text', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('more') ?>" name="<?php echo $this->get_field_name('more') ?>" value="<?php echo esc_attr($instance['more']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('more_url') ?>"><?php _e('More URL', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('more_url') ?>" name="<?php echo $this->get_field_name('more_url') ?>" value="<?php echo esc_attr($instance['more_url']) ?>" />
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('all_linkable') ?>">
                <input type="checkbox" id="<?php echo $this->get_field_id('all_linkable') ?>" name="<?php echo $this->get_field_name('all_linkable') ?>" <?php checked($instance['all_linkable']) ?> />
                <?php _e('Link title and icon to "More URL"', 'vantage') ?>
            </label>
        </p>
		<!--
		<p>
			<label for="<?php echo $this->get_field_id('box') ?>">
				<input type="checkbox" id="<?php echo $this->get_field_id('box') ?>" name="<?php echo $this->get_field_name('box') ?>" <?php checked($instance['box']) ?> />
				<?php _e('Show Box Container', 'vantage') ?>
			</label>
		</p>
		-->
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance['box'] = !empty($new_instance['box']);
		return $new_instance;
	}
}

class Vantage_Headline_Widget extends WP_Widget {
	public function __construct() {
		// widget actual processes
		parent::__construct(
			'headline-widget', // Base ID
			__('Vantage Headline', 'vantage'), // Name
			array( 'description' => __( 'A lovely big headline.', 'vantage' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		?>
		<h1><?php echo esc_html($instance['headline']) ?></h1>
		<div class="decoration"><div class="decoration-inside"></div></div>
		<h3><?php echo wp_kses_post($instance['sub_headline']) ?></h3>
		<?php

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'headline' => '',
			'sub_headline' => '',
		) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id('headline') ?>"><?php _e('Headline', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('headline') ?>" name="<?php echo $this->get_field_name('headline') ?>" value="<?php echo esc_attr($instance['headline']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('sub_headline') ?>"><?php _e('Sub Headline', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('sub_headline') ?>" name="<?php echo $this->get_field_name('sub_headline') ?>" value="<?php echo esc_attr($instance['sub_headline']) ?>" />
		</p>
		<?php
	}
}

/**
 * Register the Vantage specific widgets.
 */
function vantage_register_widgets(){
	register_widget('Vantage_CircleIcon_Widget');
	register_widget('Vantage_Headline_Widget');
}
add_action( 'widgets_init', 'vantage_register_widgets');

/**
 * Filter the carousel loop title to add navigation controls.
 */
function vantage_filter_carousel_loop($title, $instance = array(), $id = false){
	if($id == 'siteorigin-panels-postloop' && isset($instance['template']) && $instance['template'] == 'loops/loop-carousel.php') {
		$title = '<div class="vantage-carousel-title"><span class="vantage-carousel-title-text">'.$title.'</span><a href="#" class="next">next</a><a href="#" class="previous">previous</a></div>';
	}
	return $title;
}
add_filter('widget_title', 'vantage_filter_carousel_loop', 10, 3);

/**
 * Handle ajax requests for the carousel.
 */
function vantage_carousel_ajax_handler(){
	if(empty($_GET['query'])) return;

	$query = $_GET['query'];
	$query['paged'] = $_GET['paged'];

	query_posts($query);
	ob_start();
	get_template_part('loops/loop', 'carousel');

	global $wp_query;
	$count = $wp_query->post_count;

	// Reset everything
	wp_reset_query();
	wp_reset_postdata();

	header('content-type:application/json');
	echo json_encode( array(
		'html' => ob_get_clean(),
		'count' => $count,
	) );

	exit();
}
add_action('wp_ajax_vantage_carousel_load', 'vantage_carousel_ajax_handler');
add_action('wp_ajax_nopriv_vantage_carousel_load', 'vantage_carousel_ajax_handler');