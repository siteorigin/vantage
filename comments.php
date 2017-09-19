<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to vantage_comment() which is
 * located in the inc/template-tags.php file.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?>

<?php if ( post_password_required() ) return; ?>

	<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 id="comments-title">
			<?php
				printf(
					_nx( 'One Comment', '%1$s Comments', get_comments_number(), 'comments title', 'vantage' ),
					number_format_i18n( get_comments_number() )
				);
			?>
		</h2>
		
		<?php
	        $args = array(
	        	'prev_text'	=> esc_html__( '&larr; Older Comments', 'vantage' ),
	        	'next_text'	=> esc_html__( 'Newer Comments &rarr;', 'vantage' )
	        );
			the_comments_navigation( $args ); 
		?>
		
		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'vantage_comment' ) ); ?>
		</ol><!-- .commentlist -->

		<?php
	        $args = array(
	        	'prev_text'	=> esc_html__( '&larr; Older Comments', 'vantage' ),
	        	'next_text'	=> esc_html__( 'Newer Comments &rarr;', 'vantage' )
	        );
			the_comments_navigation( $args ); 
		?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'vantage' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments .comments-area -->
