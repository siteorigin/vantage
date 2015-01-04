<?php

function vantage_premium_upgrade_content($content){
	$content['premium_title'] = __('Upgrade To Vantage Premium', 'vantage');
	$content['premium_summary'] = __("If you've enjoyed using Vantage, you're going to love Vantage Premium. It's a robust upgrade to Vantage that gives you some useful features. You choose the price, so you can decide what it's worth to give your site a professional edge.", 'vantage');

	$content['buy_url'] = 'https://siteorigin.fetchapp.com/sell/nctheigh';
	$content['premium_video_poster'] = get_template_directory_uri().'/upgrade/poster.jpg';
	$content['premium_video_id'] = '74123479';

	$content['features'] = array();

	$content['features'][] = array(
		'heading' => __('Premium Support', 'vantage'),
		'content' => __("Need help setting up Vantage? Upgrading to Vantage Premium gives you prioritized forum support and email support if you need it. We have a growing support team ready to help you with your questions.", 'vantage'),
	);

	$content['features'][] = array(
		'heading' => __('Name The Price', 'vantage'),
		'content' => __("You can choose exactly how much you pay for Vantage Premium. Pay what ever you think the features are worth to you. Regardless, you're supporting the continued development of Vantage.", 'vantage'),
	);

	$content['features'][] = array(
		'heading' => __("Responsive Features", 'vantage'),
		'content' => __("The final puzzle pieces in making Vantage fully responsive. Vantage Premium has footer widgets that collapse below each other on small screen devices. Its menu collapses into a single navigate button which activates an intuitive nested menu system and site search.", 'vantage'),
		'image' => get_template_directory_uri().'/upgrade/teasers/mobile-nav.png',
	);

	$content['features'][] = array(
		'heading' => __('Remove Attribution Links', 'vantage'),
		'content' => __('Vantage premium gives you the option to easily remove the "Powered by WordPress, Theme by SiteOrigin" text from your footer. ', 'vantage'),
		'image' => get_template_directory_uri().'/upgrade/teasers/attribution.png',
	);

	$content['features'][] = array(
		'heading' => __("Retina Logo", 'vantage'),
		'content' => __("No one wants a fuzzy logo. Vantage Premium lets you upload a second, double-size logo that's only displayed to users with retina screens.", 'vantage'),
		'image' => get_template_directory_uri().'/upgrade/teasers/retina-logo.png',
	);

	$content['features'][] = array(
		'heading' => __('Customizer Integration', 'vantage'),
		'content' => __("Make Vantage your own with customizer integration. Change fonts, colors and more all using the live-updating WordPress customizer.", 'vantage'),
		'image' => get_template_directory_uri().'/upgrade/teasers/customizer.png',
	);

	$content['features'][] = array(
		'heading' => __('Page Builder Element Styles', 'vantage'),
		'content' => __("Vantage Premium has additional styles for the Page Builder elements button and call to action. Give your site a unique look and feel with loads of colour variations.", 'vantage'),
		'image' => get_template_directory_uri().'/upgrade/teasers/pb-elements.png',
	);

	$content['features'][] = array(
		'heading' => __("Enhanced Social Media Widget", 'vantage'),
		'content' => __("Additional social networks and sizes (small and large) for the social media widget. Networks include LinkedIn, Dribbble, Flickr, Instagram, Pinterest, Skype, YouTube, GitHub and Vimeo. With more coming as they're requested.", 'vantage'),
		'image' => get_template_directory_uri().'/upgrade/teasers/social-widget.png',
	);

	$content['features'][] = array(
		'heading' => __("Ajax Comments", 'vantage'),
		'content' => __("Want to keep the conversation flowing? Ajax comments means your visitors can comment without reloading your page. So commenting wont interrupt a video or lose their position in one of your galleries.", 'vantage'),
	);

	$content['features'][] = array(
		'heading' => __("Post Sharing", 'vantage'),
		'content' => __("Add post sharing icons to the bottom of every post on your blog. It's about time to go viral.", 'vantage'),
		'image' => get_template_directory_uri().'/upgrade/teasers/share.png',
	);

	$content['features'][] = array(
		'heading' => __("CSS Editor", 'vantage'),
		'content' => __("A simple CSS editor that lets you easily add code that changes the look of Vantage. You can count on our support staff to help you with CSS snippets to get the look you're after. Best of all, your changes will persist across updates.", 'vantage'),
	);

	$content['features'][] = array(
		'heading' => __("Continued Updates", 'vantage'),
		'content' => __("You'll help support the continued development of Vantage - ensuring it works with future versions of WordPress for years to come.", 'vantage'),
	);

	$content['testimonials'] = array(
		array(
			'gravatar' => '10169e5514e607d8cb97f0f6bddbd728',
			'name' => 'Ian',
			'content' => __("Vantage is simple and clean. The user interface is easy to use. Combined with the developers Page Builder plugin makes it a powerful theme with great support.", 'vantage'),
		),
		array(
			'gravatar' => '3e5f90609c33ea3ceb01d0be7b3a4e39',
			'name' => 'Bart',
			'content' => __('Clean, simple and powerful. Like other themes from SiteOrigin.', 'vantage'),
		),
		array(
			'gravatar' => 'c99edc83049dddbd926f86214c662a8f',
			'name' => 'Dave Vic',
			'content' => __('Combined Vantage and Page builder are now one of the best combinations to have a premium WordPress theme.', 'vantage'),
		),
	);

	return $content;
}
add_filter('siteorigin_premium_content', 'vantage_premium_upgrade_content');

/**
 * Add a feature notice
 */
function vantage_upgrade_panels_upgrade_note(){
	?><p><?php printf( __('Additional styles are available in <a href="%s" target="_blank">Vantage Premium</a>.', 'vantage'), admin_url('themes.php?page=premium_upgrade') ) ?></p><?php
}
add_action('siteorigin_panels_widget_after_styles', 'vantage_upgrade_panels_upgrade_note');