<?php
/**
 * Loop Name: Blog
 */
?>
<?php if ( have_posts() ) { ?>

	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) {
		the_post(); ?>

		<?php get_template_part( 'content', get_post_format() ); ?>

	<?php } ?>

	<?php vantage_content_nav( 'nav-below' ); ?>

<?php } else { ?>

	<?php get_template_part( 'no-results' ); ?>

<?php } ?>
