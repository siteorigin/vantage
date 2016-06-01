<?php
if ( ! function_exists( 'vantage_settings_tour' ) ) :

function vantage_settings_tour($tour){
	$tour = array();

	$tour[] = array(
		'title' => __( 'Welcome to Vantage', 'vantage' ),
		'content' => __( 'Vantage is a powerful, multipurpose theme. This quick tour will guide you through some of the basic setup and features.', 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/logo.png',
	);

	$tour[] = array(
		'title' => __( 'Upload Your Logo', 'vantage' ),
		'content' => __( 'The first step to making your site uniquely your own is to upload your custom logo. Choose a logo image below, and it will replace the plain-text site title. Any size will work, but we recommend that you use a smaller version of your logo.', 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/upload-logo.jpg',
		'setting' => 'logo_image',
	);

	$tour[] = array(
		'title' => __( 'Upload Your Retina Logo', 'vantage' ),
		'content' => __( 'A retina logo is a double-sized version of your standard logo. Vantage displays this version of your logo to users with high pixel density displays. Currently, these are most common on mobile devices, but they are starting to infiltrate desktop devices too.', 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/upload-logo-retina.jpg',
		'setting' => 'logo_image_retina',
	);

	$tour[] = array(
		'title' => __( 'Choose a Layout', 'vantage' ),
		'content' => __( 'Vantage supports two different layouts: boxed and full-width. Full-width is the default setting, but it is possible that boxed will give you a look you prefer. Boxed also gives you access to the custom background feature.', 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/width.jpg',
		'setting' => 'layout_bound',
	);

	$tour[] = array(
		'title' => __( 'Change the Header Text', 'vantage' ),
		'content' => __( 'The header text, which by default reads "Call Me, Maybe?" is a great place to add your site slogan or contact details. You can also overwrite this area entirely by adding widgets to the header widget area.', 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/header-text.jpg',
		'setting' => 'logo_header_text',
	);

	$tour[] = array(
		'title' => __( 'Change the Slider', 'vantage' ),
		'content' => __( "The home page slider is a great place to show off your images or branding message. You'll need to install Meta Slider to create any new sliders. Once you do, the sliders will show up in this drop down list. For now, you can just disable the default slider until you create your own.", 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/slider.jpg',
		'setting' => 'home_slider',
	);

	if( ! function_exists('siteorigin_panels_render') ) {
		// Only include this step of the tour if Page Builder is not enabled.
		$tour[] = array(
			'title' => __( 'Install Page Builder', 'vantage' ),
			'content' => __( "Page Builder is the easiest way to create a site that makes you proud. Navigate to Appearance > Home Page in your WordPress admin to install it. After you've installed it, you will be able to create columnized pages using your widgets.", 'vantage' ),
			'image' => get_template_directory_uri() . '/tour/steps/page-builder.jpg',
			'action' => array(
				'text' => __( 'Install Page Builder', 'vantage' ),
				'href' => function_exists('siteorigin_plugin_activation_install_url') ?  siteorigin_plugin_activation_install_url( 'siteorigin-panels', __('Page Builder', 'siteorigin') ) : '#',
			),
			'video' => 101728633,
		);
	}

	$tour[] = array(
		'title' => __( 'Enable Post Sharing', 'vantage' ),
		'content' => __( "This setting toggles a social sharing box that appears below your blog posts. This box lets your users quickly share your content on Facebook, Twitter, and Google Plus.", 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/sharing.png',
		'setting' => 'social_share_post',
	);

	$tour[] = array(
		'title' => __( 'Additional Settings', 'vantage' ),
		'content' => __( "There are a lot of additional settings that we haven't covered in this brief tour. Navigate to Appearance > Theme Settings at any time to take a look. You'll be amazed at what you can accomplish with a few clicks.", 'vantage' ),
		'image' => get_template_directory_uri() . '/tour/steps/additional.png',
	);

	if( !defined('SITEORIGIN_IS_PREMIUM') ) {
		// Only show this step if the user isn't already using premium
		$tour[] = array(
			'title' => __( 'Check Out Vantage Premium', 'vantage' ),
			'content' => __( "You may have noticed that some settings and features are only available in Vantage Premium. This is a cost-effective upgrade that gives you access to a lot of bonus features. Take a look to see if this is something you might find useful.", 'vantage' ),
			'image' => get_template_directory_uri() . '/tour/steps/premium.jpg',
			'action' => array(
				'text' => __( 'More About Vantage Premium', 'vantage' ),
				'href' => admin_url('themes.php?page=premium_upgrade'),
			),
			'video' => 74123479,
		);
	}

	return $tour;
}
endif;
add_filter('siteorigin_settings_tour_content', 'vantage_settings_tour');
