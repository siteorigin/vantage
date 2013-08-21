<?php
/**
 * Displays 
 * 
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>

	<div class="entry-main">

		<?php do_action('vantage_before_single_entry') ?>

		<header class="entry-header">

			<?php if( has_post_thumbnail() ): ?>
				<div class="entry-thumbnail"><?php the_post_thumbnail() ?></div>
			<?php endif; ?>

			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'vantage' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

			<?php if ( get_post_type() == 'post' ) : ?>
				<div class="entry-meta">
					<?php vantage_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>

		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'vantage' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'vantage' ), 'after' => '</div>' ) ); ?>
			<p>
				<?php the_tags('<p class="tags"><strong>'.__('Tags: ', 'vantage').'</strong>', ', ', '</p>') ?>
			</p>
		</div><!-- .entry-content -->

		<?php do_action('vantage_after_single_entry') ?>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
