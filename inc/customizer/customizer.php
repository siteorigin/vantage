<?php

if ( class_exists( 'WP_Customize_Control' ) && !class_exists('SiteOrigin_Customize_Fonts_Control') ) :
/**
 * A customizer control for choosing web fonts
 */
class SiteOrigin_Customize_Fonts_Control extends WP_Customize_Control {
	function __construct( $manager, $id, $args = array() ) {
		// Let other themes and plugins process the web fonts array
		$google_web_fonts = include ( dirname(__FILE__) . '/google-fonts.php' );

		// Add the default fonts
		$choices = array(
			'Helvetica Neue' => 'Helvetica Neue',
			'Lucida Grande' => 'Lucida Grande',
			'Arial' => 'Arial',
			'Verdana' => 'Verdana',
			'Georgia' => 'Georgia',
			'Courier New' => 'Courier New',
		);

		foreach ( $google_web_fonts as $font => $variants ) {
			foreach ( $variants as $variant ) {
				if ( $variant == 'regular' || $variant == 400 ) {
					$choices[ $font ] = $font;
				}
				else {
					$choices[ $font . ':' . $variant ] = $font . ' (' . $variant . ')';
				}
			}
		}

		$args = wp_parse_args( $args, array(
			'type' => 'select',
			'choices' => $choices,
		) );
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Render the control. Renders the control wrapper, then calls $this->render_content().
	 */
	protected function render() {
		$id = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', $this->id ) );
		$class = 'customize-control customize-control-' . $this->type . ' customize-control-font';

		?>
		<li id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php $this->render_content(); ?>
		</li>
		<?php
	}
}
endif;

if(!class_exists('SiteOrigin_Customizer_CSS_Builder ')) :
/**
 * This is used for building custom CSS.
 */
class SiteOrigin_Customizer_CSS_Builder {
	private $css;
	private $raw_css;
	private $fonts;
	private $defaults;

	// These are web safe fonts
	static $web_safe = array(
		'Helvetica Neue' => 'Arial, Helvetica, Geneva, sans-serif',
		'Lucida Grande' => 'Lucida, Verdana, sans-serif',
		'Arial' => 'Arial, Helvetica, sans-serif',
		'Verdana' => 'Verdana, Geneva, sans-serif',
		'Georgia' => '"Times New Roman", Times, serif',
		'Courier New' => 'Courier, mono',
	);

	function __construct($defaults) {
		$this->css = array();
		$this->raw_css = '';
		$this->google_fonts = array();
		$this->defaults = $defaults;
	}

	/**
	 * Echo all the CSS
	 */
	function css() {
		// Start by importing Google web fonts
		$return = '<style type="text/css" id="customizer-css">';

		$import = array();
		foreach ( $this->google_fonts as $font ) {
			$import[ ] = urlencode( $font[ 0 ] ) . ':' . $font[ 1 ];
		}
		$import = array_unique( $import );
		if ( !empty( $import ) ) {
			$return .= '@import url(http' . ( is_ssl() ? 's' : '' ) . '://fonts.googleapis.com/css?family=' . implode( '|', $import ) . '); ';
		}

		foreach ( $this->css as $selector => $rules ) {
			$return .= $selector . ' { ' . implode( '; ', $rules ) . ' } ';
		}
		if( !empty($this->raw_css) ) $return .= $this->raw_css;

		$return .= '</style>';
		return $return;
	}

	/**
	 * Add a raw CSS value
	 *
	 * @param $selector
	 * @param $property
	 * @param $value
	 */
	function add_css( $selector, $property, $value ) {
		if ( empty( $value ) ) return;

		$selector = preg_replace( '/\s+/m', ' ', $selector );

		if ( $property == 'font' ) {
			if ( strpos( $value, ':' ) !== false ) list( $family, $variant ) = explode( ':', $value, 2 );
			else {
				$family = $value;
				$variant = 400;
			}

			if ( !empty( self::$web_safe[ $family ] ) ) $family = '"' . $family . '", ' . self::$web_safe[ $family ];
			else {
				$this->google_fonts[ ] = array( $family, $variant );
				$family = '"' . $family . '"';
			}

			$this->add_css( $selector, 'font-family', $family );
			if ( $variant != 400 ) $this->add_css( $selector, 'font-weight', $variant );

			return;
		}

		if ( empty( $this->css[ $selector ] ) ) $this->css[ $selector ] = array();

		$this->css[ $selector ][ ] = $property . ': ' . $value;
	}

	/**
	 * Add some basic, raw CSS.
	 *
	 * @param string $css The raw CSS.
	 */
	function add_raw_css($css){
		$this->raw_css .= ' '.$css;
	}

	/**
	 * Adds a Google web font or web safe font
	 *
	 * @param string $selector The selector we want to use the web font with.
	 * @param string $mod The theme mod where the font is stored.
	 */
	function add_web_font( $selector, $mod ) {
		$font = get_theme_mod($mod);
		if(empty($font) || empty($this->defaults[$mod]) || $font == $this->defaults[$mod]) return;

		if ( empty( $this->css[ $selector ] ) ) $this->css[ $selector ] = array();

		if ( strpos( $font, ':' ) !== false ) list( $family, $variant ) = explode( ':', $font, 2 );
		else {
			$variant = 400;
			$family = $font;
		}

		if ( !empty( self::$web_safe[ $family ] ) ) $family = '"' . $family . '", ' . self::$web_safe[ $family ];
		else {
			$this->google_fonts[ ] = array( $family, $variant );
			$family = '"' . $family . '"';
		}

		$this->add_css( $selector, 'font-family', $family );
		if ( $variant != 400 ) $this->add_css( $selector, 'font-weight', $variant );

		$this->fonts[ ] = $font;

		if ( !empty( $variant ) ) {
			if ( $variant == 'regular' ) $variant = '400';
			$this->css[ $selector ][ ] = 'font-weight: ' . $variant;
		}
	}

	/**
	 * Adds a color property.
	 *
	 * @param $selector
	 * @param $property
	 * @param $mod
	 */
	function add_color($selector, $property, $mod) {
		$color = get_theme_mod($mod);
		if(empty($color) || empty($this->defaults[$mod]) || $color == $this->defaults[$mod]) return;

		$this->add_css($selector, $property, $color);
	}

	/**
	 * Add an image URL
	 *
	 * @param $selector
	 * @param $property
	 * @param $mod
	 */
	function add_image($selector, $property, $mod) {
		$image = get_theme_mod($mod);
		if(!empty($image)) {
			$this->add_css($selector, $property, 'url("'.esc_url($image).'")');
		}
	}

	/**
	 * Adds a measurement property
	 *
	 * @param $selector
	 * @param $property
	 * @param $mod
	 * @param string $units
	 */
	function add_measurement($selector, $property, $mod, $units = 'px') {
		$value = get_theme_mod( $mod );
		$measurement = floatval( $value );

		if( !is_float( $value ) || empty($this->defaults[$mod]) || $measurement == $this->defaults[$mod] ) return;

		$this->add_css($selector, $property, $measurement.$units);
	}

	/**
	 * Convert a HEX value to an RGB array
	 *
	 * @param $hex
	 *
	 * @return array
	 */
	static function hex2rgb($hex) {
		$hex = str_replace( "#", "", $hex );

		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		}
		else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}

		return array( $r, $g, $b );
	}

}
endif;

/**
 * Sanitize a Google font.
 *
 * @param string $font
 *
 * @return string
 */
function siteorigin_customizer_sanitize_google_font($font){

	// Check the default fonts too.
	$default_fonts = array(
		'Helvetica Neue' => 'Helvetica Neue',
		'Lucida Grande' => 'Lucida Grande',
		'Arial' => 'Arial',
		'Verdana' => 'Verdana',
		'Georgia' => 'Georgia',
		'Courier New' => 'Courier New',
	);

	$google_fonts = include( dirname(__FILE__).'/google-fonts.php' );
	$font_name_parts = explode( ':', $font, 2 );
	$font_name = $font_name_parts[0];

	if( empty($google_fonts[$font_name]) && empty($default_fonts[$font_name]) ) $font = '';
	return $font;
}

/**
 * Sanitize a float value
 *
 * @param $value
 *
 * @return float
 */
function siteorigin_customizer_sanitize_floatval($value) {
	return floatval( $value );
}

/**
 * Sanitize an integer value
 *
 * @param $value
 *
 * @return int
 */
function siteorigin_customizer_sanitize_intval($value) {
	return intval( $value );
}

/**
 * Sanitize an image URL
 *
 * @param $image
 *
 * @return string
 */
function siteorigin_customizer_sanitize_image($image){
	return esc_url_raw($image);
}

if( !class_exists('SiteOrigin_Customizer_Helper') ) :

class SiteOrigin_Customizer_Helper {
	private $theme;
	private $settings;
	private $sections;
	private $defaults;

	function __construct($settings = array(), $sections = array(), $theme, $root_url = false, $make_single = true){
		// Give child themes a chance to filter this.
		$this->theme = $theme;
		$this->defaults = array();
		$this->settings = array();

		$this->add_sections($sections);
		$this->add_settings($settings);

		// Add a script that will help us with our previews
		add_action( 'customize_preview_init', array( $this, 'enqueue' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'admin_enqueue' ) );

		if( $make_single ) {
			global $siteorigin_customize_helper_single;
			$siteorigin_customize_helper_single = $this;
		}
	}

	/**
	 * Get the global instance of the siteorigin customize helper
	 *
	 * @return mixed
	 */
	static function single(){
		global $siteorigin_customize_helper_single;
		if( empty($siteorigin_customize_helper_single) ) {
			new SiteOrigin_Customizer_Helper();
		}

		return $siteorigin_customize_helper_single;
	}

	/**
	 * Add sections to the customizer helper.
	 *
	 * @param array $sections
	 */
	function add_sections($sections = array()){
		$sections = apply_filters($this->theme.'_siteorigin_theme_customizer_sections', $sections);
		$this->sections = wp_parse_args($sections, $this->sections);
	}

	/**
	 * Add settings to the customzier helper.
	 *
	 * @param array $settings
	 */
	function add_settings($settings = array()){
		$settings = apply_filters($this->theme.'_siteorigin_theme_customizer_settings', $settings);

		foreach($settings as $section_id => $section_settings) {
			foreach($section_settings as $id => $setting) {
				$setting['section'] = $section_id;
				$this->settings[$section_id.'_'.$id] = $setting;

				if(!empty($setting['default'])) {
					$this->defaults[$section_id.'_'.$id] = $setting['default'];
				}
			}
		}
	}

	/**
	 * Registers all the customizations with the WordPress customize manager. Should be called by function tied to customize_register action.
	 *
	 * @param WP_Customize_Manager $wp_customize
	 */
	function customize_register($wp_customize){

		// Add the panel that will contain all the theme settings
		$theme = wp_get_theme();
		$wp_customize->add_panel( 'siteorigin_theme_settings', array(
			'priority'       => 50,
			'capability'     => 'edit_theme_options',
			'title'          => __('Theme Design', 'vantage'),
			'description'    => sprintf( __('Theme Specific Customizations For %s.', 'vantage'), $theme->get('Name') ),
		) );

		// Start by registering all the sections
		foreach($this->sections as $id => $section) {
			$section = wp_parse_args( $section, array(
				'panel' => 'siteorigin_theme_settings'
			) );
			$wp_customize->add_section( $id, $section );
		}

		static $priority = 0;

		// Now add all the settings
		foreach($this->settings as $id => $setting) {

			switch($setting['type']) {
				case 'font' :
					$sanitize_callback = 'siteorigin_customizer_sanitize_google_font';
					break;

				case 'color' :
					$sanitize_callback = 'sanitize_hex_color';
					break;

				case 'measurement' :
					$sanitize_callback = 'siteorigin_customizer_sanitize_floatval';
					break;

				case 'image' :
					$sanitize_callback = 'siteorigin_customizer_sanitize_image';
					break;

				default:
					$sanitize_callback = 'sanitize_text_field';
					break;
			}

			$wp_customize->add_setting( $id, array(
				'default' => !empty($setting['default']) ? $setting['default'] : '',
				'sanitize_callback' => $sanitize_callback,
			) );

			// Can't use live changes with a callback
			if( !empty($setting['callback']) ) $setting['no_live'] = true;

			// Now lets add a control for this setting
			switch($setting['type']) {
				case 'font' :
					$wp_customize->add_control( new SiteOrigin_Customize_Fonts_Control( $wp_customize, $this->theme.'_'.$id, array(
						'label' => $setting['title'],
						'section' => $setting['section'],
						'settings' => $id,
						'priority' => $priority++,
					) ) );
					break;

				case 'color' :
					$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $this->theme.'_'.$id, array(
						'label' => $setting['title'],
						'section' => $setting['section'],
						'settings' => $id,
						'priority' => $priority++,
					) ) );
					if ( empty( $setting['no_live'] ) ) $wp_customize->get_setting( $id )->transport = 'postMessage';
					break;

				case 'measurement' :
					$wp_customize->add_control( $id, array(
						'label' => $setting['title'],
						'section' => $setting['section'],
						'type'    => 'text',
						'priority' => $priority++,
					) );
					if( empty( $setting['no_live'] ) ) $wp_customize->get_setting( $id )->transport = 'postMessage';
					break;

				case 'image' :
					$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $this->theme.'_'.$id, array(
						'label' => $setting['title'],
						'section' => $setting['section'],
						'settings' => $id,
						'priority' => $priority++,
					) ) );
					break;

				case 'image_select' :
					$wp_customize->add_control( new SiteOrigin_Customize_Image_Select_Control( $wp_customize, $this->theme.'_'.$id, array(
						'label' => $setting['title'],
						'section' => $setting['section'],
						'settings' => $id,
						'priority' => $priority++,
					) ) );
					break;

				default :
					$wp_customize->add_control( $id, array(
						'label' => $setting['title'],
						'section' => $setting['section'],
						'type'    => $setting['type'],
						'priority' => $priority++,
						'choices' => isset($setting['choices']) ? $setting['choices'] : null,
					) );
					break;
			}
		}
	}

	/**
	 * Create the CSS builder with all the current values
	 *
	 * @return SiteOrigin_CSS_Builder
	 */
	function create_css_builder(){
		$builder = new SiteOrigin_Customizer_CSS_Builder($this->defaults);

		foreach($this->settings as $id => $setting) {
			if( !empty($setting['selector']) ) {
				foreach((array) $setting['selector'] as $selector) {
					switch($setting['type']) {
						case 'font' :
							$builder->add_web_font($selector, $id);
							break;

						case 'color' :
							foreach((array) $setting['property'] as $property) {
								$builder->add_color($selector, $property, $id);
							}
							break;

						case 'measurement' :
							foreach((array) $setting['property'] as $property) {
								$builder->add_measurement($selector, $property, $id, $setting['unit']);
							}
							break;

						case 'image' :
							foreach((array) $setting['property'] as $property) {
								$builder->add_image($selector, $property, $id);
							}
							break;

						default :
							if( isset($setting['property']) ) {
								foreach ( (array) $setting['property'] as $property ) {
									$builder->add_css( $selector, $property, get_theme_mod($id) );
								}
							}
							break;

					}
				}
			}

			if(isset($setting['callback'])) {
				$val = get_theme_mod($id);
				if(isset( $setting['default'] ) && $val != $setting['default']) {
					call_user_func( $setting['callback'], $builder, $val, array_merge( $setting, array('id' => $id) ) );
				}
			}
		}

		$builder = apply_filters( $this->theme . '_siteorigin_customizer_custom_css', $builder, $this->settings, $this->defaults );

		return $builder;
	}

	/**
	 * Enqueue the customizer scripts
	 */
	function enqueue(){
		wp_enqueue_script('siteorigin-customizer-preview', get_template_directory_uri() . '/inc/customizer/js/live-customizer' . SITEORIGIN_THEME_JS_PREFIX . '.js', array( 'jquery','customize-preview' ), SITEORIGIN_THEME_VERSION);
		wp_localize_script('siteorigin-customizer-preview', 'customizeSettings', $this->settings);
	}

	/**
	 * Enqueue scripts for the actual customizer admin
	 */
	function admin_enqueue( ){
		wp_enqueue_script('siteorigin-customizer-admin', get_template_directory_uri() . '/inc/customizer/js/admin' . SITEORIGIN_THEME_JS_PREFIX . '.js', array( 'jquery', 'customize-controls' ), SITEORIGIN_THEME_VERSION);
		wp_localize_script('siteorigin-customizer-admin', 'soCustomizeAdmin', array(
			'confirm' => __('Are you sure you want to reset your theme customizations?', 'vantage'),
			'button' => __('Reset Customizations', 'vantage'),
			'action' => wp_nonce_url(
				add_query_arg( array(
					'return' => add_query_arg(false, false),
					'action' => 'so_customize_reset'
				), admin_url('admin-ajax.php') ),
				'so_customize_reset'
			)
		));

		wp_enqueue_style('siteorigin-customizer-admin', get_template_directory_uri() . '/inc/customizer/css/admin.css', array( ), SITEORIGIN_THEME_VERSION );
	}

	/**
	 * Reset all defaults
	 */
	function reset_defaults(){
		foreach($this->settings as $id => $values) {
			remove_theme_mod( $id );
		}
	}
}

endif;