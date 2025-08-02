<?php
/**
 * Loop Name: Carousel Slider
 */

$ajax_url = add_query_arg(
	array(
		'vantage_carousel_nonce' => wp_create_nonce( 'vantage_carousel_action' ),
	),
	admin_url( 'admin-ajax.php' )
);
?>
<div class="vantage-carousel-wrapper">
	<?php $vars = vantage_get_query_variables(); ?>

	<ul
		class="vantage-carousel"
		data-query="<?php echo esc_attr( json_encode( $vars ) ); ?>"
		data-ajax-url="<?php echo esc_url( $ajax_url ); ?>"
	>
		<?php while ( have_posts() ) {
			the_post(); ?>
			<li class="carousel-entry">
				<div class="thumbnail">
					<?php if ( has_post_thumbnail() ) {
						$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'vantage-carousel' ); ?>
						<a href="<?php the_permalink(); ?>" style="background-image: url(<?php echo esc_url( $img[0] ); ?>)">
						</a>
					<?php } else { ?>
						<a href="<?php the_permalink(); ?>" class="default-thumbnail"><span class="vantage-overlay"></span></a>
					<?php } ?>
				</div>
				<?php
				$title = get_the_title();

				if ( empty( $title ) ) {
					$title = __( 'Post ', 'vantage' ) . get_the_ID();
				} ?>
				<h3><a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php echo esc_html( $title ); ?></a></h3>
			</li>
		<?php } ?>
	</ul>
</div>
