<?php
/**
 * Loop Name: Carousel Slider
 */
?>
<div class="vantage-carousel-wrapper">

	<?php $vars = vantage_get_query_variables(); ?>

	<ul class="vantage-carousel" data-query="<?php echo esc_attr(json_encode( $vars )) ?>" data-ajax-url="<?php echo esc_url( admin_url('admin-ajax.php') ) ?>">
		<?php while( have_posts() ) : the_post(); ?>
			<li class="carousel-entry">
				<div class="thumbnail">
					<?php $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'vantage-carousel'); ?>
					<?php if( $img[0] ) : ?>
						<a href="<?php the_permalink() ?>" style="background-image: url(<?php echo $img[0] ?>)">
						</a>
					<?php else : ?>
						<a href="<?php the_permalink() ?>" class="default-thumbnail"><span class="vantage-overlay"></span></a>
					<?php endif; ?>
				</div>
				<?php
				$title = get_the_title();
				if( empty( $title ) ) {
					$title = __( 'Post', 'vantage' ) . ' ' . get_the_ID();
				} ?>
				<h3><a href="<?php the_permalink() ?>"><?php echo $title ?></a></h3>
			</li>
		<?php endwhile; ?>
	</ul>
</div>
