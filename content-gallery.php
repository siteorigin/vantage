<?php
/**
 * Template part for displaying gallery format posts.
 *
 * @package vantage
 * @since vantage 1.5.8
 * @license GPL 2.0
 */

$gallery = get_post_gallery( get_the_ID(), false );
$content = vantage_strip_gallery( get_the_content() );
$content = str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $content ) );
$post_class = ( is_singular() ) ? 'post' : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>>

	<div class="entry-main">

		<?php do_action( 'vantage_entry_main_top' ) ?>

		<?php if ( ( the_title( '', '', false ) && siteorigin_page_setting( 'page_title' ) ) || ( has_post_thumbnail() && siteorigin_setting('blog_featured_image') ) || has_post_format( 'gallery' ) && $gallery != '' || ( siteorigin_setting( 'blog_post_metadata' ) && get_post_type() == 'post' ) ) : ?>
			<header class="entry-header">

			<?php if ( $gallery != '' ) : ?>
				<div class="flexslider gallery-format-slider">
					<ul class="slides gallery-format-slides">
						<?php foreach ( $gallery['src'] as $image ) : ?>
							<li class="gallery-format-slide">
								<img src="<?php echo $image; ?>">
							</li>
						<?php endforeach; ?>
					<ul>
				</div>
				<?php elseif ( has_post_thumbnail() && siteorigin_setting( 'blog_featured_image' ) ) : ?>
					<div class="entry-thumbnail">
						<?php if ( is_singular() ) : ?>
							<?php vantage_entry_thumbnail(); ?>
						<?php else : ?>
							<a href="<?php the_permalink() ?>">
								<?php vantage_entry_thumbnail(); ?>
							</a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( is_singular() ) : ?>
					<?php if ( the_title( '', '', false ) && siteorigin_page_setting( 'page_title' ) ) : ?>
						<?php the_title( '<h1 class="entry-title test">', '</h1>' ); ?>
					<?php endif; ?>
				<?php else : ?>
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'vantage' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<?php endif; ?>

				<?php if ( siteorigin_setting( 'blog_post_metadata' ) && get_post_type() == 'post' ) : ?>
					<div class="entry-meta">
						<?php vantage_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>

			</header><!-- .entry-header -->
		<?php endif; ?>

		<div class="entry-content">
			<?php echo $content; ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'vantage' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

		<?php if ( is_singular() && vantage_get_post_categories() && ! is_singular( 'jetpack-testimonial' ) ) : ?>
			<div class="entry-categories">
				<?php echo vantage_get_post_categories(); ?>
			</div>
		<?php endif; ?>

		<?php if ( is_singular() && siteorigin_setting( 'blog_author_box' ) ) vantage_author_box( $post ); ?>

		<?php do_action( 'vantage_entry_main_bottom' ); ?>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
