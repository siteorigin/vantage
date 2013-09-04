<?php
wp_enqueue_script('vantage-demo-slider', get_template_directory_uri().'/slider/demo.js', array('jquery'), SITEORIGIN_THEME_VERSION);
wp_enqueue_style('vantage-demo-slider', get_template_directory_uri().'/slider/demo.css', array(), SITEORIGIN_THEME_VERSION);
wp_enqueue_style('vantage-demo-slider-animate', get_template_directory_uri().'/slider/animate.css', array(), SITEORIGIN_THEME_VERSION);
?>

<div class="flexslider" id="metaslider-demo">
	<ul class="slides">

		<li>
			<div class="content">
				<img src="<?php echo get_template_directory_uri() ?>/slider/backgrounds/slide-1.jpg" width="1080" height="420" />
			</div>
		</li>

		<li>
			<div class="content">
				<img src="<?php echo get_template_directory_uri() ?>/slider/backgrounds/slide-2.jpg" width="1080" height="420" />
			</div>
		</li>

		<li>
			<div class="content">
				<img src="<?php echo get_template_directory_uri() ?>/slider/backgrounds/slide-3.jpg" width="1080" height="420" />
			</div>
		</li>

	</ul>
</div>