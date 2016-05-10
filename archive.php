<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

get_header(); ?>

<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

		<header class="page-header">
			<h1 id="page-title"><?php if( siteorigin_page_setting( 'page_title' ) ) { echo vantage_get_archive_title(); } ?></h1>
			<?php
			if ( is_category() ) {
				// show an optional category description
				$category_description = category_description();
				if ( ! empty( $category_description ) )
					echo apply_filters( 'vantage_category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );

			}
			elseif ( is_tag() ) {
				// show an optional tag description
				$tag_description = tag_description();
				if ( ! empty( $tag_description ) )
					echo apply_filters( 'vantage_tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
			}
			else {
				$description = term_description();
				if ( ! empty( $description ) )
					echo apply_filters( 'vantage_taxonomy_archive_meta', '<div class="taxonomy-description">' . $description . '</div>' );
			}
			?>
		</header><!-- .page-header -->

		<?php get_template_part( 'loops/loop', siteorigin_setting('blog_archive_layout') ) ?>

	</div><!-- #content .site-content -->
</section><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
