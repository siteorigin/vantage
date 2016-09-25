<?php
/**
 * Loop Name: Circle Icons
 */
?>

<?php if( have_posts() ) : $i = 0; ?>
	<div id="vantage-circleicon-loop" class="vantage-circleicon-loop circleicon-loop-columns-<?php echo siteorigin_setting('blog_circle_column_count') ?>">

		<?php
		while( have_posts() ){
			the_post();
			$i++;
			$image = wp_get_attachment_image_src( get_post_thumbnail_id() );

			the_widget(
				'Vantage_CircleIcon_Widget',
				array(
					'image' => !empty($image[0]) ? $image[0] : false,
					'title' => get_the_title(),
					'text' => get_the_excerpt(),
					'more' => siteorigin_setting( 'blog_read_more' ),
					'more_url' => get_permalink(),
					'all_linkable' => true,
					'icon_position' => 'top',
				)
			);

			if($i % siteorigin_setting( 'blog_circle_column_count' ) == 0) : ?><div class="clear"></div><?php endif;

		}
		?>
	</div>
	<?php vantage_content_nav( 'nav-below' ); ?>
<?php endif; ?>
