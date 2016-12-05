<?php
/**
 * Template part for displaying video format posts.
 *
 * @package vantage
 * @since vantage 1.5.8
 * @license GPL 2.0
 */

$post_class = ( is_singular() ) ? 'post' : '';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $post ); ?>>

	<div class="entry-main test">

		<?php do_action( 'vantage_entry_main_top' ) ?>

		<?php if ( ( the_title( '', '', false ) && siteorigin_page_setting( 'page_title' ) ) || ( has_post_thumbnail() && siteorigin_setting( 'blog_featured_image' ) ) || has_post_format( 'video' ) && vantage_get_video() || ( siteorigin_setting( 'blog_post_metadata' ) && get_post_type() == 'post' ) ) : ?>
			<header class="entry-header">

				<?php if ( vantage_get_video() ) : ?>
					<div class="entry-thumbnail">
						<?php echo vantage_get_video(); ?>
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
			<?php // Display the content without first video ?>
			<?php echo apply_filters( 'the_content', vantage_filter_video( get_the_content() ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'vantage' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

		<?php if ( is_singular() && vantage_get_post_categories() && ! is_singular( 'jetpack-testimonial' ) ) : ?>
			<div class="entry-categories">
				<?php echo vantage_get_post_categories(); ?>
			</div>
		<?php endif; ?>

		<?php if ( is_singular() && siteorigin_setting( 'blog_author_box' ) ) : ?>
			<div class="author-box">
				<div class="avatar-box">
					<div class="avatar-wrapper"><?php echo get_avatar( get_the_author_meta( 'user_email' ), 70 ) ?></div>
				</div>
				<div class="box-content entry-content">
					<h3 class="box-title"><?php echo esc_html( get_the_author_meta( 'display_name' ) ) ?></h3>
					<div class="box-description">
						<?php if ( get_the_author_meta( 'description' ) ) : ?>
							<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ) ?>
						<?php elseif ( current_user_can( 'edit_users', $post->post_author ) ) : ?>
							<a href="<?php echo get_edit_user_link( $post->post_author ); ?>"><?php _e( 'Add author biographical info.', 'vantage' ) ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php do_action( 'vantage_entry_main_bottom' ); ?>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->