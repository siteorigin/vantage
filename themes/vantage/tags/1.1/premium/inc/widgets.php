<?php

class Vantage_Premium_Social_Media_Widget extends WP_Widget{

	private $networks;

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'vantage-social-media',
			__('Vantage Social Media', 'vantage'),
			array(
				'description' => __( 'Add nice little icons that link out to your social media profiles.', 'text_domain' )
			)
		);

		$this->networks = array(
			'facebook' => __('Facebook', 'vantage'),
			'twitter' => __('Twitter', 'vantage'),
			'linkedin' => __('LinkedIn', 'vantage'),
			'dribbble' => __('Dribbble', 'vantage'),
			'facebook' => __('Facebook', 'vantage'),
			'flickr' => __('Flickr', 'vantage'),
			'instagram' => __('Instagram', 'vantage'),
			'pinterest' => __('Pinterest', 'vantage'),
			'rss' => __('RSS', 'vantage'),
			'skype' => __('Skype', 'vantage'),
			'youtube' => __('YouTube', 'vantage'),
			'github' => __('GitHub', 'vantage'),
			'google-plus' => __('Google Plus', 'vantage'),

			// These ones don't have FontAwesome Icons
			'vimeo' => __('Vimeo', 'vantage'),
		);
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget
		echo $args['before_widget'];

		if(!empty($instance['title'])) {
			echo $args['before_title'].$instance['title'].$args['after_title'];
		}

		foreach($this->networks as $id => $name) {
			if(!empty($instance[$id])) {
				?><a class="social-media-icon social-media-icon-<?php echo $id ?> social-media-icon-<?php echo esc_attr($instance['size']) ?>" href="<?php echo esc_url( $instance[$id] ) ?>" title="<?php echo esc_html( get_bloginfo('name') . ' ' . $name ) ?>" <?php if(!empty($instance['new_window'])) echo 'target="_blank"'; ?>><?php

				switch($id) {
					case 'vimeo' :
						?><img src="<?php echo get_template_directory_uri() ?>/premium/images/brands/vimeo.png" /><?php
						break;
					default :
						echo '<span class="icon-' . $id . '" />';
				}

				?></a><?php
			}
		}

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$instance = wp_parse_args($instance, array(
			'size' => 'medium',
			'title' => '',
			'new_window' => false,
		) );

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title') ?>"><?php _e('Title') ?></label><br/>
			<input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title') ?>" value="<?php echo esc_attr($instance['title']) ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('size') ?>"><?php _e('Icon Size') ?></label><br/>
			<select id="<?php echo $this->get_field_id('size') ?>" name="<?php echo $this->get_field_name('size') ?>">
				<option value="small" <?php selected($instance['size'], 'small') ?>><?php esc_html_e('Small', 'vantage') ?></option>
				<option value="medium" <?php selected($instance['size'], 'medium') ?>><?php esc_html_e('Medium', 'vantage') ?></option>
				<option value="large" <?php selected($instance['size'], 'large') ?>><?php esc_html_e('Large', 'vantage') ?></option>
			</select>
		</p>
		<?php

		foreach($this->networks as $id => $name) {
			?>
			<p>
				<label for="<?php echo $this->get_field_id($id) ?>"><?php echo $name ?></label>
				<input type="text" id="<?php echo $this->get_field_id($id) ?>" name="<?php echo $this->get_field_name($id) ?>" value="<?php echo esc_attr(!empty($instance[$id]) ? $instance[$id] : '') ?>" class="widefat"/>
			</p>
			<?php
		}

		?>
		<p>
			<input type="checkbox" name="<?php echo $this->get_field_name('new_window') ?>" id="<?php echo $this->get_field_id('new_window') ?>" <?php checked($instance['new_window']) ?> />
			<label for="<?php echo $this->get_field_id('new_window') ?>"><?php _e('Open in New Window') ?></label>

		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$new_instance['new_window'] = !empty($new_instance['new_window']);
		return $new_instance;
	}
}

function vantage_premium_register_widgets(){
	register_widget( 'Vantage_Premium_Social_Media_Widget' );
}
add_action( 'widgets_init', 'vantage_premium_register_widgets');