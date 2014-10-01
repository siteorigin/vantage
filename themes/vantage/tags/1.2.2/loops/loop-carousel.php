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
					<?php if( has_post_thumbnail() ) : $img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'vantage-carousel'); ?>
						<a href="<?php the_permalink() ?>" style="background-image: url(<?php echo esc_url($img[0]) ?>)">
							<span class="overlay"></span>
						</a>
					<?php else : ?>
						<a href="<?php the_permalink() ?>" class="default-thumbnail"><span class="overlay"></span></a>
					<?php endif; ?>
				</div>
				<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
			</li>
		<?php endwhile; ?>
	</ul>
</div>