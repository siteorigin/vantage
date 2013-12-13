<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

		<article id="post-0" class="post error404 not-found">

			<div class="entry-main">

				<?php do_action('vantage_entry_main_top') ?>

				<header class="entry-header">
					<h1 class="entry-title"><?php echo apply_filters( 'vantage_404_title', __( "That page can't be found.", 'vantage' ) ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p><?php echo apply_filters( 'vantage_404_message', __( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'vantage' ) ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<div class="widget">
						<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'vantage' ); ?></h2>
						<ul>
						<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
						</ul>
					</div><!-- .widget -->

					<?php
					$archive_content = '<p>' . __( 'Try looking in the monthly archives.', 'vantage' ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

				</div><!-- .entry-content -->

				<?php do_action('vantage_entry_main_bottom') ?>

			</div><!-- .entry-main -->

		</article><!-- #post-0 .post .error404 .not-found -->

	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_footer(); ?>