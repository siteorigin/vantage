<?php
/**
 * Template part for displaying single posts.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>

	<div class="entry-main">

		<?php do_action('vantage_entry_main_top') ?>

		<?php if ( ( the_title( '', '', false ) && siteorigin_page_setting( 'page_title' ) ) || ( has_post_thumbnail() && siteorigin_setting('blog_featured_image') ) || ( siteorigin_setting( 'blog_post_metadata' ) && get_post_type() == 'post' ) ) : ?>
			<header class="entry-header">

				<?php if( has_post_thumbnail() && siteorigin_setting('blog_featured_image') ): ?>
					<div class="entry-thumbnail"><?php vantage_entry_thumbnail(); ?></div>
				<?php endif; ?>

				<?php if ( the_title( '', '', false ) && siteorigin_page_setting( 'page_title' ) ) : ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php endif; ?>

				<?php if ( siteorigin_setting( 'blog_post_metadata' ) && get_post_type() == 'post' ) : ?>
					<div class="entry-meta">
						<?php vantage_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>

			</header><!-- .entry-header -->
		<?php endif; ?>

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'vantage' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

		<?php if( vantage_get_post_categories() && ! is_singular( 'jetpack-testimonial' ) ) : ?>
			<div class="entry-categories">
				<?php echo vantage_get_post_categories() ?>
			</div>
		<?php endif; ?>

		<?php if ( is_singular() && siteorigin_setting( 'blog_author_box' ) ) vantage_author_box( $post ); ?>

		<?php do_action('vantage_entry_main_bottom') ?>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
