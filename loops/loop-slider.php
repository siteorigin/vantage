<?php
/**
 * Just displays a slider loop. Intended to be included in child themes using get_template_part('loop', 'slider'). Also works with SiteOrigin page builder loop widget.
 *
 * Loop Name: Slider
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?>

<?php if ( have_posts() ) : ?>

<div class="flexslider-wrapper">
	<div class="flexslider">
		<ul class="slides">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php if( has_post_thumbnail() ) : ?>
					<li class="slide">
						<a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail('vantage-slide'); ?>
							<div class="flex-caption">
								<h3><?php the_title() ?></h3>
							</div>
						</a>
					</li>
				<?php elseif( 'attachment' == get_post_type() && wp_get_attachment_image_src(get_post_thumbnail_id(), 'vantage-slide') ) : ?>
					<li class="slide">
						<a href="<?php the_permalink() ?>">
							<?php echo wp_get_attachment_image( get_the_ID(), 'vantage-slide' ); ?>
							<div class="flex-caption">
								<h3><?php the_title() ?></h3>
							</div>
						</a>
					</li>
				<?php endif; ?>
			<?php endwhile; ?>
		</ul>
	</div>
</div>

<?php endif; ?>
