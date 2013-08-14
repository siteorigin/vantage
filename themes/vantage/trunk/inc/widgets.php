<?php

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

		?>
		<div class="circle-icon-box icon-position-<?php echo esc_attr($instance['icon_position']) ?>">
			<div class="circle-icon-wrapper">
				<div class="circle-icon" <?php if(!empty($instance['image'])) : ?>style="background-image: url(<?php echo esc_url($instance['image']) ?>)"<?php endif; ?>></div>
			</div>
			<?php if(!empty($instance['title'])) : ?><h4><?php echo esc_html($instance['title']) ?></h4><?php endif; ?>
			<?php if(!empty($instance['text'])) : ?><p class="text"><?php echo wp_kses_post($instance['text']) ?></p><?php endif; ?>
			<?php if(!empty($instance['more_url'])) : ?>
				<a href="<?php echo esc_url($instance['more_url']) ?>" class="more-button"><?php echo !empty($instance['more']) ? esc_html($instance['more']) : __('More Info', 'vantage') ?> <i></i></a>
			<?php endif; ?>
		</div>
		<?php

		echo $args['after_widget'];
	}

 	public function form( $instance ) {
		$instance = wp_parse_args( $instance, array(
			'title' => '',
			'text' => '',
			'image' => '',
			'icon_position' => 'top',
			'more' => '',
			'more_url' => '',
		) );

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
			<label for="<?php echo $this->get_field_id('image') ?>"><?php _e('Image URL', 'vantage') ?></label>
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
			<label for="<?php echo $this->get_field_id('more') ?>"><?php _e('More Text', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('more') ?>" name="<?php echo $this->get_field_name('more') ?>" value="<?php echo esc_attr($instance['more']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('more_url') ?>"><?php _e('More URL', 'vantage') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('more_url') ?>" name="<?php echo $this->get_field_name('more_url') ?>" value="<?php echo esc_attr($instance['more_url']) ?>" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
}

/**
 * Register the Vantage specific widgets.
 */
function vantage_register_widgets(){
	register_widget('Vantage_CircleIcon_Widget');
}
add_action( 'widgets_init', 'vantage_register_widgets');

/**
 * Filter the carousel loop title to add navigation controls.
 */
function vantage_filter_carousel_loop($title, $instance, $id){
	if($id == 'siteorigin-panels-postloop' && isset($instance['template']) && $instance['template'] == 'loop-carousel.php') {
		$title = '<div class="vantage-carousel-title"><span class="vantage-carousel-title-text">'.$title.'</span><a href="#" class="next">next</a><a href="#" class="previous">previous</a></div>';
	}
	return $title;
}
add_filter('widget_title', 'vantage_filter_carousel_loop', 10, 3);

function vantage_carousel_ajax_handler(){
	if(empty($_GET['query'])) return;

	$query = $_GET['query'];
	$query['paged'] = $_GET['paged'];

	query_posts($query);
	ob_start();
	get_template_part('loop', 'carousel');

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