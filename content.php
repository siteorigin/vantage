<?php
/**
 * Displays
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() && siteorigin_setting( 'blog_featured_image_type' ) == 'icon' ): ?>
		<div class="entry-thumbnail">
			<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( 'thumbnail' ) ?></a>
		</div>
	<?php endif; ?>

	<div class="entry-main">

		<?php do_action('vantage_entry_main_top') ?>

		<header class="entry-header">
			<?php if ( has_post_thumbnail() && siteorigin_setting( 'blog_featured_image_type' ) == 'large' ): ?>
				<div class="entry-thumbnail">
					<a href="<?php the_permalink() ?>"><?php vantage_entry_thumbnail(); ?></a>
				</div>
			<?php endif; ?>

			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'vantage' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

			<?php if ( siteorigin_setting( 'blog_post_metadata' ) && 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php vantage_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>

		</header><!-- .entry-header -->

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
		<?php else : ?>
			<div class="entry-content">
				<?php if ( siteorigin_setting( 'blog_archive_content' ) == 'excerpt' ) the_excerpt(); else the_content(); ?>
				<?php $read_more_text = siteorigin_setting( 'blog_read_more' ) ? esc_html( siteorigin_setting( 'blog_read_more' ) ) : __( 'Continue reading', 'vantage' ); ?>
				<?php echo ( ( siteorigin_setting( 'blog_read_more_button' ) && siteorigin_setting( 'blog_archive_content' ) == 'excerpt' ) ? '<a class="more-link" href="' . get_permalink() . '">' . $read_more_text .'<span class="meta-nav">&rarr;</span></a>' : '' ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'vantage' ), 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
		<?php endif; ?>

		<?php do_action('vantage_entry_main_bottom') ?>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
