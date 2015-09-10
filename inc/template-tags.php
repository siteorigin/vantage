<?php
/**
 * Custom template tags for this theme.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

if ( ! function_exists( 'vantage_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since vantage 1.0
 */
function vantage_content_nav( $nav_id ) {
	$jetpack_infinite_scroll_active = class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' );
	//Check if we're in the Page Builder Post Loop widget.
	$is_page_builder_post_loop_widget = class_exists( 'SiteOrigin_Panels_Widgets_PostLoop' ) &&
	                                    method_exists( 'SiteOrigin_Panels_Widgets_PostLoop', 'is_rendering_loop' ) &&
	                                    SiteOrigin_Panels_Widgets_PostLoop::is_rendering_loop();

	if( $jetpack_infinite_scroll_active && ! $is_page_builder_post_loop_widget ) {
		return;
	}
	global $wp_query, $post;

	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	// Add the shorten title filter
	add_filter('the_title', 'vantage_content_nav_shorten_title');

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'vantage' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<div class="single-nav-wrapper">
			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'vantage' ) . '</span> %title' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'vantage' ) . '</span>' ); ?>
		</div>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php vantage_pagination() ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php

	// Remove the shorten title filter
	remove_filter('the_title', 'vantage_content_nav_shorten_title');
}
endif; // vantage_content_nav

/**
 * Filter the title to shorten it. This is used by vantage_content_nav function.
 *
 * @param $title
 * @return string
 */
function vantage_content_nav_shorten_title($title){
	if(strlen($title) > 40) {
		$title = wp_trim_words($title, 5);
	}

	return $title;
}

if ( ! function_exists( 'vantage_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since vantage 1.0
 */
function vantage_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
			?>
			<li class="post pingback">
				<p><?php _e( 'Pingback:', 'vantage' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'vantage' ), ' ' ); ?></p>
			<?php
			break;
		default :
			?>
			<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>" class="comment">
					<footer>
						<?php echo get_avatar( $comment, 50 ); ?>
						<div class="comment-author">
							<cite class="fn"><?php comment_author_link() ?></cite>
						</div><!-- .comment-author -->


						<div class="comment-meta commentmetadata">
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>"><?php
								/* translators: 1: date, 2: time */
								printf( __( '%1$s at %2$s', 'vantage' ), get_comment_date(), get_comment_time() );
								?></time></a>

							<span class="support">
								<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
								<?php edit_comment_link( __( 'Edit', 'vantage' ), ' ' ); ?>
							</span>
						</div><!-- .comment-meta .commentmetadata -->

						<?php if ( $comment->comment_approved == '0' ) : ?>
							<em class="awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'vantage' ); ?></em>
						<?php endif; ?>
					</footer>

					<div class="comment-content entry-content"><?php comment_text(); ?></div>
				</article><!-- #comment-## -->
		
			<?php
			break;
	endswitch;
}
endif; // ends check for vantage_comment()

if ( ! function_exists( 'vantage_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since vantage 1.0
 */
function vantage_posted_on() {
	$date_time = '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a><time class="updated" datetime="%5$s">%6$s</time>';
	$date_time = sprintf( $date_time,
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		apply_filters('vantage_post_on_date', esc_html( get_the_date() )),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$author = sprintf('<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'vantage' ), get_the_author() ) ),
		get_the_author()
	);


	$comments_link = '<span class="comments-link"><a href="' . get_comments_link() . '">' . get_comments_number_text( 'Leave a comment' ) . '</a></span>';

	$posted_on_parts = array(
		'on' => sprintf( __( 'Posted on %s', 'vantage'), $date_time ),
		'by' => sprintf( __( '<span class="byline"> by %s</span>', 'vantage' ), $author),
		'with' => ' | ' . $comments_link
	);
	$posted_on_parts = apply_filters( 'vantage_post_on_parts', $posted_on_parts );

	$posted_on = implode(' ', $posted_on_parts);
	echo apply_filters('vantage_posted_on', $posted_on);
}
endif;

if(!function_exists('vantage_display_logo')):
/**
 * Display the logo 
 */
function vantage_display_logo(){
	$logo = siteorigin_setting( 'logo_image' );
	$logo = apply_filters('vantage_logo_image_id', $logo);

	if( empty($logo) ) {
		if ( function_exists( 'jetpack_the_site_logo' ) && jetpack_has_site_logo() ) {
			// We'll let Jetpack handle things
			jetpack_the_site_logo();
			return;
		}

		// Just display the site title
		$logo_html = '<h1 class="site-title">'.get_bloginfo( 'name' ).'</h1>';
		$logo_html = apply_filters('vantage_logo_text', $logo_html);
	}
	else {
		// load the logo image
		if(is_array($logo)) {
			list ($src, $height, $width) = $logo;
		}
		else {
			$image = wp_get_attachment_image_src($logo, 'full');
			$src = $image[0];
			$height = $image[2];
			$width = $image[1];
		}

		// Add all the logo attributes
		$logo_attributes = apply_filters('vantage_logo_image_attributes', array(
			'src' => $src,
			'class' => siteorigin_setting('logo_in_menu_constrain') ? 'logo-height-constrain' : 'logo-no-height-constrain',
			'width' => round($width),
			'height' => round($height),
			'alt' => sprintf( __('%s Logo', 'vantage'), get_bloginfo('name') ),
		) );

		if($logo_attributes['width'] > vantage_get_site_width()) {
			// Don't let the width be more than the site width.
			$width = vantage_get_site_width();
			$logo_attributes['height'] = round($logo_attributes['height'] / ($logo_attributes['width'] / $width));
			$logo_attributes['width'] = $width;
		}

		$logo_attributes_str = array();
		if( !empty( $logo_attributes ) ) {
			foreach($logo_attributes as $name => $val) {
				if( empty($val) ) continue;
				$logo_attributes_str[] = $name.'="'.esc_attr($val).'" ';
			}
		}

		$logo_html = apply_filters('vantage_logo_image', '<img '.implode( ' ', $logo_attributes_str ).' />');
	}

	// Echo the image
	echo apply_filters('vantage_logo_html', $logo_html);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since vantage 1.0
 */
function vantage_categorized_blog() {
	if ( false === ( $count = get_transient( 'vantage_categorized_blog_cache_count' ) ) ) {
		// Count the number of non-empty categories
		$count = count( get_categories( array(
			'hide_empty' => 1,
		) ) );
		
		// Count the number of categories that are attached to the posts
		set_transient( 'vantage_categorized_blog_cache_count', $count );
	}
	
	// Return true if this blog has categories, or else false.
	return ($count >= 1);
}

/**
 * Flush out the transients used in vantage_categorized_blog
 *
 * @since vantage 1.0
 */
function vantage_category_transient_flusher() {
	delete_transient( 'vantage_categorized_blog_cache_count' );
}
add_action( 'edit_category', 'vantage_category_transient_flusher' );
add_action( 'save_post', 'vantage_category_transient_flusher' );

if( !function_exists( 'vantage_get_archive_title' ) ) :
/**
 * Return the archive title depending on which page is being displayed.
 * 
 * @since vantage 1.0
 */
function vantage_get_archive_title(){
	$title = '';
	global $wp_query;
	if ( is_category() ) {
		$title = sprintf( __( 'Category Archives: %s', 'vantage' ), '<span>' . single_cat_title( '', false ) . '</span>' );

	}
	elseif ( is_tag() ) {
		$title = sprintf( __( 'Tag Archives: %s', 'vantage' ), '<span>' . single_tag_title( '', false ) . '</span>' );

	}
	elseif ( is_author() ) {
		the_post();
		$title = sprintf( __( 'Author Archives: %s', 'vantage' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
		rewind_posts();

	}
	elseif ( is_day() ) {
		$title = sprintf( __( 'Daily Archives: %s', 'vantage' ), '<span>' . get_the_date() . '</span>' );

	}
	elseif ( is_month() ) {
		$title = sprintf( __( 'Monthly Archives: %s', 'vantage' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

	}
	elseif ( is_year() ) {
		$title = sprintf( __( 'Yearly Archives: %s', 'vantage' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

	}
	elseif ( !empty($wp_query->query_vars['taxonomy']) ) {
		$value = get_query_var($wp_query->query_vars['taxonomy']);
		$term = get_term_by('slug',$value,$wp_query->query_vars['taxonomy']);
		$tax = get_taxonomy( $wp_query->query_vars['taxonomy'] );
		$title = sprintf( __( '%s: %s', 'vantage' ), $tax->label, $term->name );
	}
	else {
		$title = __( 'Archives', 'vantage' );
	}
	
	return apply_filters('vantage_archive_title', $title);
}
endif;

/**
 * Get the post meta.
 * 
 * @since vantage 1.0
 */
function vantage_get_post_categories(){
	/* translators: used between list items, there is a space after the comma */
	$category_list = get_the_category_list( __( ', ', 'vantage' ) );

	/* translators: used between list items, there is a space after the comma */
	$tag_list = get_the_tag_list( '', __( ', ', 'vantage' ) );

	if ( ! vantage_categorized_blog() || ! siteorigin_setting( 'blog_post_categories' ) ) {
		// This blog only has 1 category or so we just need to worry about tags in the meta text
		if ( '' != $tag_list && siteorigin_setting( 'blog_post_tags' ) ) {
			$meta_text = __( '<strong>Tagged</strong> %2$s.', 'vantage' );
		}
		else {
			$meta_text = '';
		}

	}
	else {
		// But this blog has loads of categories so we should probably display them here
		if ( '' != $tag_list && siteorigin_setting( 'blog_post_tags' )) {
			$meta_text = __( 'Posted in %1$s and tagged %2$s.', 'vantage' );
		}
		else {
			$meta_text = __( 'Posted in %1$s.', 'vantage' );
		}

	} // end check for categories on this blog

	$meta = sprintf(
		$meta_text,
		$category_list,
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
	
	return apply_filters('vantage_post_meta', $meta);
}

/**
 * Gets the URL that should be displayed when clicking on an image in the view image page.
 * 
 * @param null $post
 * @return string
 */
function vantage_next_attachment_url($post = null){
	if(empty($post)){
		global $post;
	}
	
	/**
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
	 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
	 */
	$attachments = array_values( get_children( array(
		'post_parent'    => $post->post_parent,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) ) );
	foreach ( $attachments as $k => $attachment ) {
		if ( $attachment->ID == $post->ID )
			break;
	}
	$k++;
	// If there is more than 1 attachment in a gallery
	if ( count( $attachments ) > 1 ) {
		if ( isset( $attachments[ $k ] ) ){
			// get the URL of the next image attachment
			$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
		}
		else{
			// or get the URL of the first image attachment
			$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
		}
			
	}
	else {
		// or, if there's only 1 image, get the URL of the image
		$next_attachment_url = wp_get_attachment_url();
	}
	
	return $next_attachment_url;
}

if( !function_exists( 'vantage_pagination' ) ) :
/**
 * Display the pagination
 *
 * @param string $pages
 * @param int $range
 */
function vantage_pagination($pages = '', $range = 2) {

	$showitems = ($range * 2)+1;

	global $wp_query, $wp_rewrite;
	$paged = $wp_query->get('paged');
	if(empty($paged)) $paged = 1;

	if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages) $pages = 1;
	}

	if(1 != $pages) {
		$format_permalink = substr( get_pagenum_link(false), -1, 1 ) == '/' ? 'page/%#%/' : '/page/%#%/';
		$format_query_string = strpos(get_pagenum_link(false), '?') === false ? '?paged=%#%' : '&paged=%#%';

		echo "<div class='pagination'>";
		echo paginate_links( array(
			'total' => $pages,
			'current' => $paged,
			'mid_size' => $showitems,
			'format' => ( $wp_rewrite->permalink_structure == '' || is_search() ) ? $format_query_string : $format_permalink,
			'base' => get_pagenum_link(false).'%_%',
		) );
		echo "</div>\n";
	}
}
endif;

if( !function_exists( 'vantage_read_more_link' ) ) :
/**
 * Filter the read more link.
 */
function vantage_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">' . esc_html( siteorigin_setting('blog_read_more') ) .'<span class="meta-nav">&rarr;</span></a></span';
}
add_filter( 'the_content_more_link', 'vantage_read_more_link' );
endif;