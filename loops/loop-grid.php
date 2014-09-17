<?php
/**
 * Loop Name: Grid
 */
?>
<?php if( have_posts() ) : $i = 0; ?>

	<div class="vantage-grid-loop">
		<?php while( have_posts() ): the_post(); $i++; ?>
			<article <?php post_class(array('grid-post')) ?>>

				<?php if( has_post_thumbnail() ) : ?>
					<a class="grid-thumbnail" href="<?php the_permalink() ?>">
						<?php the_post_thumbnail('vantage-grid-loop') ?>
					</a>
				<?php endif; ?>

				<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
				<div class="excerpt"><?php the_excerpt() ?></div>
			</article>
			<?php if($i % 4 == 0) : ?><div class="clear"></div><?php endif; ?>
		<?php endwhile; ?>
	</div>

	<?php vantage_content_nav( 'nav-below' ); ?>

<?php endif; ?>