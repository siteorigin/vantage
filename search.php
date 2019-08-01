<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<?php if ( siteorigin_page_setting( 'page_title' ) ) : ?>
				<h1 id="page-title"><?php printf( __( 'Search Results for: %s', 'vantage' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			<?php endif; ?>
		</header><!-- .page-header -->

	<?php endif; ?>

		<?php get_template_part( 'loops/loop', siteorigin_setting( 'layout_search' ) ); ?>

	</div><!-- #content .site-content -->
</section><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
