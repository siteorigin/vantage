<?php

function vantage_premium_upgrade_content($content){
	$content['premium_title'] = __('Upgrade To Vantage Premium', 'vantage');
	$content['premium_summary'] = __("If you've enjoyed using Vantage, you're going to love Vantage Premium. It's a robust upgrade to vantage that gives you some useful features. You choose the price, so you can decide what it's worth to give your site a professional edge.", 'vantage');

	$content['buy_url'] = 'http://siteorigin.fetchapp.com/sell/nctheigh';
	$content['premium_video_poster'] = get_template_directory_uri().'/upgrade/poster.jpg';
	$content['premium_video_id'] = '74123479';
	// $content['roadmap'] = 'http://siteorigin.com/vantage-documentation/vantage-roadmap/';

	$content['features'] = array();

	$content['features'][] = array(
		'heading' => __('Premium Email Support', 'vantage'),
		'content' => __("Need help setting up vantage? Upgrading to vantage Premium gives you email support.", 'vantage'),
	);

	$content['features'][] = array(
		'heading' => __('Name The Price', 'vantage'),
		'content' => __("You can choose exactly how much you pay for vantage Premium. Pay what ever you think the features are worth to you. Regardless, you're supporting the continued development of vantage.", 'vantage'),
	);

	$content['features'][] = array(
		'heading' => __("Responsive Features", 'vantage'),
		'content' => __("The final puzzle pieces in making vantage fully responsive. Vantage Premium has footer widgets that collapse below each other on small screen devices. Its menu collapses into a single navigate button which activates an intuitive nested menu system and site search.", 'vantage'),
	);

	$content['features'][] = array(
		'heading' => __('Remove Attribution Links', 'vantage'),
		'content' => __('vantage premium gives you the option to easily remove the "Powered by WordPress, Theme by SiteOrigin" text from your footer. ', 'vantage'),
	);

	$content['features'][] = array(
		'heading' => __("Ajax Comments", 'vantage'),
		'content' => __("Want to keep the conversation flowing? Ajax comments means your visitors can comment without reloading your page. So commenting wont interrupt a video or lose their position in one of your galleries.", 'vantage'),
	);

	$content['features'][] = array(
		'heading' => __("CSS Editor", 'vantage'),
		'content' => __("A simple CSS editor that lets you easily add code that changes the look of vantage. You can count on our support staff to help you with CSS snippets to get the look you're after. Best of all, your changes will persist across updates.", 'vantage'),
	);

	$content['features'][] = array(
		'heading' => __("Continued Updates", 'vantage'),
		'content' => __("You'll help support the continued development of vantage - ensuring it works with future versions of WordPress for years to come.", 'vantage'),
	);

	return $content;
}
add_filter('siteorigin_premium_content', 'vantage_premium_upgrade_content');