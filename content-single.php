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

		<?php do_action('vantage_entry_main_top') ?>

		<header class="entry-header">

			<?php if( has_post_thumbnail() && siteorigin_setting('blog_featured_image') ): ?>
				<div class="entry-thumbnail"><?php the_post_thumbnail( is_active_sidebar('sidebar-1') ? 'post-thumbnail' : 'vantage-thumbnail-no-sidebar' ) ?></div>
			<?php endif; ?>

			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'vantage' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

			<?php if ( siteorigin_setting( 'blog_post_metadata' ) && get_post_type() == 'post' ) : ?>
				<div class="entry-meta">
					<?php vantage_posted_on(); ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>

		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'vantage' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'vantage' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->

		<?php if(vantage_get_post_categories()) : ?>
			<div class="entry-categories">
				<?php echo vantage_get_post_categories() ?>
			</div>
		<?php endif; ?>

		<?php if( is_singular() && siteorigin_setting('blog_author_box') ) : ?>
			<div class="author-box">
				<div class="avatar-box">
					<div class="avatar-wrapper"><?php echo get_avatar( get_the_author_meta('user_email'), 70 ) ?></div>
				</div>
				<div class="box-content entry-content">
					<h3 class="box-title"><?php echo esc_html( get_the_author_meta('display_name') ) ?></h3>
					<div class="box-description">
						<?php echo wp_kses_post( wpautop( get_the_author_meta('description') ) ) ?>
					</div>
				</div>
			</div>
		<?php endif; ?>


		<?php do_action('vantage_entry_main_bottom') ?>

	</div>

</article><!-- #post-<?php the_ID(); ?> -->
