<?php
/**
 * Custom template tags for this theme.
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */

if ( ! function_exists( 'vantage_author_box' ) ) :
/**
 * Display the post author biographical info on single posts.
 */
function vantage_author_box( $post ) { ?>
	<div class="author-box">
		<div class="avatar-box">
			<div class="avatar-wrapper">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), 70 ); ?>
				</a>
			</div>
		</div>
		<div class="box-content entry-content">
			<div class="box-title">
				<h3><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></h3>
				<span class="author-posts">
					<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
						<?php esc_html_e( 'View posts by ', 'vantage' );
							echo get_the_author(); ?>
					</a>
				</span>
			</div>
			<div class="box-description">
				<?php if ( get_the_author_meta( 'description' ) ) : ?>
					<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
				<?php elseif ( current_user_can( 'edit_users', $post->post_author ) ) : ?>
					<a href="<?php echo get_edit_user_link( $post->post_author ); ?>"><?php esc_html_e( 'Add author biographical info.', 'vantage' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php }
endif;

if ( ! function_exists( 'vantage_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since vantage 1.0
 */
function vantage_content_nav( $nav_id ) {
	$jetpack_infinite_scroll_active = class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' );
	// Check if we're in the Page Builder Post Loop widget.
	$is_page_builder_post_loop_widget = class_exists( 'SiteOrigin_Panels_Widgets_PostLoop' ) &&
	                                    method_exists( 'SiteOrigin_Panels_Widgets_PostLoop', 'is_rendering_loop' ) &&
	                                    SiteOrigin_Panels_Widgets_PostLoop::is_rendering_loop();

	if ( $jetpack_infinite_scroll_active && ! $is_page_builder_post_loop_widget ) {
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

	// Add the shorten title filter.
	add_filter( 'the_title', 'vantage_content_nav_shorten_title' );

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo $nav_class; ?>">
		<h2 class="assistive-text"><?php _e( 'Post navigation', 'vantage' ); ?></h2>

	<?php if ( is_single() ) : // Navigation links for single posts. ?>

		<div class="single-nav-wrapper">
			<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'vantage' ) . '</span> %title' ); ?>
			<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'vantage' ) . '</span>' ); ?>
		</div>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // Navigation links for home, archive, and search pages. ?>

		<?php vantage_pagination(); ?>

	<?php endif; ?>

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php

	// Remove the shorten title filter
	remove_filter( 'the_title', 'vantage_content_nav_shorten_title' );
}
endif; // vantage_content_nav

if ( ! function_exists( 'vantage_content_nav_shorten_title' ) ) :
/**
 * Filter the title to shorten it. This is used by vantage_content_nav function.
 *
 * @param $title
 * @return string
 */
function vantage_content_nav_shorten_title( $title ) {
	if ( strlen( $title ) > 40 ) {
		$title = wp_trim_words( $title, 5 );
	}

	return $title;
}
endif;

if ( ! function_exists( 'vantage_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since vantage 1.0
 */
function vantage_comment( $comment, $args, $depth, $post_id = null ) {
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
							<?php if ( $post = get_post($post_id) ) : ?>
								<?php if ( ( $comment->user_id === $post->post_author ) && siteorigin_setting( 'blog_comment_author' ) ) : ?>
									<span class="author-comment-label"><?php echo siteorigin_setting( 'blog_comment_author' ); ?></span>
								<?php endif; ?>
							<?php endif; ?>
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

	if ( ( comments_open() || get_comments_number() ) && !siteorigin_setting('blog_post_date') && !siteorigin_setting('blog_post_author') ) {
		$comments_link = '<span class="comments-link"><a href="' . get_comments_link() . '">' . get_comments_number_text() . '</a></span>';
	} elseif ( comments_open() || get_comments_number() ) {
		$comments_link = ' | <span class="comments-link"><a href="' . get_comments_link() . '">' . get_comments_number_text() . '</a></span>';
	} else {
		$comments_link = '';
	}

	$posted_on_parts = array(
		'on' => sprintf( __( 'Posted on %s', 'vantage'), $date_time ),
		'by' => sprintf( __( '<span class="byline"> by %s</span>', 'vantage' ), $author),
		'with' => $comments_link
	);
	$posted_on_parts = apply_filters( 'vantage_post_on_parts', $posted_on_parts );

	$posted_on = implode(' ', $posted_on_parts);
	echo apply_filters('vantage_posted_on', $posted_on);
}
endif;

if ( ! function_exists( 'vantage_display_logo' ) ) :
/**
 * Display the logo.
 */
function vantage_display_logo() {
	$logo = siteorigin_setting( 'logo_image' );
	if ( empty( $logo ) && function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
		$logo = get_theme_mod( 'custom_logo' );
	}
	$logo = apply_filters( 'vantage_logo_image_id', $logo );

	if ( empty( $logo ) ) {


		$title_tag = is_front_page() ? 'h1' : 'p';
		// Just display the site title.
		$logo_html = '<' . $title_tag . ' class="site-title">' . get_bloginfo( 'name' ) . '</' . $title_tag . '>';
		$logo_html = apply_filters( 'vantage_logo_text', $logo_html );
	}
	else {
		// Load the logo image.
		if ( is_array($logo) ) {
			list ( $src, $height, $width ) = $logo;
		} else {
			$image = wp_get_attachment_image_src( $logo, 'full' );
			$src = $image[0];
			$height = $image[2];
			$width = $image[1];
			$alt = get_post_meta( $logo, '_wp_attachment_image_alt', true );
		}

		// Add all the logo attributes.
		$logo_attributes = apply_filters( 'vantage_logo_image_attributes', array(
			'src' => $src,
			'class' => siteorigin_setting( 'logo_in_menu_constrain' ) ? 'logo-height-constrain' : 'logo-no-height-constrain',
			'width' => round( $width ),
			'height' => round( $height ),
			'alt' => ! empty( $alt ) ? $alt : sprintf( __( '%s Logo', 'vantage' ), get_bloginfo( 'name' ) ),
		) );

		// Try adding the retina logo.
		$retina_logo = siteorigin_setting( 'logo_image_retina' );
		if ( ! empty( $retina_logo ) ) {
			$retina_logo = apply_filters( 'vantage_logo_retina_image_id', $retina_logo );
			$retina_logo_image = wp_get_attachment_image_src($retina_logo, 'full');
			if ( !empty($retina_logo_image[0]) ) {
				$logo_attributes['srcset'] = $retina_logo_image[0] . ' 2x';
			}
		}

		if ( $logo_attributes['width'] > vantage_get_site_width() ) {
			// Don't let the width be more than the site width.
			$width = vantage_get_site_width();
			$logo_attributes['height'] = round($logo_attributes['height'] / ($logo_attributes['width'] / $width));
			$logo_attributes['width'] = $width;
		}

		$logo_attributes_str = array();
		if ( ! empty( $logo_attributes ) ) {
			foreach( $logo_attributes as $name => $val ) {
				if ( empty( $val ) ) continue;
				$logo_attributes_str[] = $name.'="'.esc_attr($val).'" ';
			}
		}

		$logo_html = apply_filters( 'vantage_logo_image', '<img ' . implode( ' ', $logo_attributes_str ) . ' />' );
	}

	// Echo the image.
	echo apply_filters( 'vantage_logo_html', $logo_html );
}
endif;

if ( ! function_exists( 'vantage_display_logo_text' ) ) :
/**
 * Display the Site Title next to the logo.
 */
function vantage_display_logo_text( $logo ) {
	$allow_text = siteorigin_setting( 'logo_with_text' );

	if ( $allow_text ) {
		$title_tag = is_front_page() ? 'h1' : 'p';
		$logo = $logo . '<' . $title_tag . ' class="site-title logo-title">' . get_bloginfo( 'name' ) . '</' . $title_tag . '>';
	}

	return $logo;

}
endif;
add_filter( 'vantage_logo_image', 'vantage_display_logo_text', 10, 1 );

if ( ! function_exists( 'vantage_categorized_blog' ) ) :
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
endif;

if ( ! function_exists( 'vantage_category_transient_flusher' ) ) :
/**
 * Flush out the transients used in vantage_categorized_blog
 *
 * @since vantage 1.0
 */
function vantage_category_transient_flusher() {
	delete_transient( 'vantage_categorized_blog_cache_count' );
}
endif;
add_action( 'edit_category', 'vantage_category_transient_flusher' );
add_action( 'save_post', 'vantage_category_transient_flusher' );

if ( ! function_exists( 'vantage_get_archive_title' ) ) :
/**
 * Return the archive title depending on which page is being displayed.
 *
 * @since vantage 1.0
 */
function vantage_get_archive_title() {
	global $wp_query;
	$prefix = '';
	$title = '';

	if ( is_category() ) {
		$prefix = __( 'Category Archives:', 'vantage' );
		$title = '<span>' . single_cat_title( '', false ) . '</span>';

	} elseif ( is_tag() ) {
		$prefix = __( 'Tag Archives:', 'vantage' );
		$title = '<span>' . single_tag_title( '', false ) . '</span>';

	} elseif ( is_author() ) {
		the_post();
		$prefix = __( 'Author Archive:', 'vantage' );
		$title = '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>';
		rewind_posts();
	} elseif ( is_day() ) {
		$prefix = __( 'Daily Archives:', 'vantage' );
		$title = '<span>' . get_the_date() . '</span>';

	} elseif ( is_month() ) {
		$prefix = __( 'Monthly Archives:', 'vantage' );
		$title = '<span>' . get_the_date( 'F Y' ) . '</span>';

	} elseif ( is_year() ) {
		$prefix = __( 'Yearly Archives:', 'vantage' );
		$title = '<span>' . get_the_date( 'Y' ) . '</span>';

	} elseif ( ! empty( $wp_query->query_vars['taxonomy'] ) ) {
		$value = get_query_var( $wp_query->query_vars['taxonomy'] );
		$term = get_term_by( 'slug',$value,$wp_query->query_vars['taxonomy'] );
		$tax = get_taxonomy( $wp_query->query_vars['taxonomy'] );
		$prefix = $tax->label . ':';
		$title = $term->name;
	}

	if ( ! empty( $title ) ) {
		$title = sprintf( __( '%s %s', 'vantage' ), siteorigin_setting( 'blog_archive_prefix_title' ) ? $prefix : '', $title );
	} else {
		$title = __( 'Archives', 'vantage' );
	}

	return apply_filters( 'vantage_archive_title', $title );
}
endif;

if ( ! function_exists( 'vantage_get_post_categories' ) ) :
/**
 * Get the post meta.
 *
 * @since vantage 1.0
 */
function vantage_get_post_categories() {
	/* translators: used between list items, there is a space after the comma */
	$category_list = get_the_category_list( __( ', ', 'vantage' ) );

	/* translators: used between list items, there is a space after the comma */
	$tag_list = get_the_tag_list( '', __( ', ', 'vantage' ) );

	if ( ! vantage_categorized_blog() || ! siteorigin_setting( 'blog_post_categories' ) ) {
		// This blog only has 1 category or so we just need to worry about tags in the meta text.
		if ( '' != $tag_list && siteorigin_setting( 'blog_post_tags' ) ) {
			$meta_text = __( '<strong>Tagged</strong> %2$s.', 'vantage' );
		} else {
			$meta_text = '';
		}

	} else {
		// But this blog has loads of categories so we should probably display them here.
		if ( '' != $tag_list && siteorigin_setting( 'blog_post_tags' ) ) {
			$meta_text = __( 'Posted in %1$s and tagged %2$s.', 'vantage' );
		}
		else {
			$meta_text = __( 'Posted in %1$s.', 'vantage' );
		}

	} // End check for categories on this blog.

	$meta = sprintf(
		$meta_text,
		$category_list,
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);

	return apply_filters( 'vantage_post_meta', $meta );
}
endif;

if ( ! function_exists( 'vantage_next_attachment_url' ) ) :
/**
 * Gets the URL that should be displayed when clicking on an image in the view image page.
 *
 * @param null $post
 * @return string
 */
function vantage_next_attachment_url( $post = null ) {
	if ( empty( $post ) ){
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
endif;

if ( ! function_exists( 'vantage_pagination' ) ) :
/**
 * Display the pagination
 *
 * @param string $pages
 * @param int $range
 */
function vantage_pagination( $pages = '', $range = 2 ) {

	$showitems = ($range * 2)+1;

	global $wp_query, $wp_rewrite;
	$paged = $wp_query->get( 'paged' );
	if ( empty( $paged ) ) $paged = 1;

	if ( $pages == '' ) {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if ( ! $pages ) $pages = 1;
	}

	if ( 1 != $pages ) {
		$format_permalink = substr( get_pagenum_link( false ), -1, 1 ) == '/' ? 'page/%#%/' : '/page/%#%/';
		$format_query_string = strpos( get_pagenum_link( false ), '?' ) === false ? '?paged=%#%' : '&paged=%#%';

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

if ( ! function_exists( 'vantage_read_more_link' ) ) :
/**
 * Filter the read more link.
 */
function vantage_read_more_link() {
	$read_more_text = siteorigin_setting( 'blog_read_more' ) ? esc_html( siteorigin_setting( 'blog_read_more' ) ) : __( 'Continue reading', 'vantage' );
	return '<a class="more-link" href="' . get_permalink() . '">' . $read_more_text .'<span class="meta-nav">&rarr;</span></a>';
}
add_filter( 'the_content_more_link', 'vantage_read_more_link' );
endif;

if ( ! function_exists( 'vantage_entry_thumbnail' ) ) :
/**
 * Display the post/page thumbnail.
 */
function vantage_entry_thumbnail() {
	if ( in_array( siteorigin_page_setting( 'layout', 'default' ), array( 'default','full-width-sidebar' ), true ) && is_active_sidebar('sidebar-1') ) {
		$thumb_size = 'post-thumbnail';
	} else {
		$thumb_size = 'vantage-thumbnail-no-sidebar';
	}
	the_post_thumbnail( $thumb_size );
}
endif;

if ( ! function_exists( 'vantage_display_icon' ) ) :
/**
 * Displays icons.
 */
function vantage_display_icon( $type ) {

	switch( $type ) {

		case 'mobile-menu':
			if ( siteorigin_setting( 'icons_menu' ) ) :
				return wp_get_attachment_image( siteorigin_setting( 'icons_menu' ), 'full', false, '' );
			else :
				return '<span class="mobile-nav-icon"></span>';
			endif;
			break;

		case 'mobile-menu-close':
			if ( siteorigin_setting( 'icons_menu_close' ) ) :
				return wp_get_attachment_image( siteorigin_setting( 'icons_menu_close' ), 'full', false, '' );
			else :
				return '<i class="fa fa-times"></i>';
			endif;
			break;

		case 'search':
			if ( siteorigin_setting( 'icons_search' ) ) :
				return wp_get_attachment_image( siteorigin_setting( 'icons_search' ), 'full', false, '' );
			else :
				return '<div class="vantage-icon-search"></div>';
			endif;
			break;

	}
}
endif;
if ( ! function_exists( 'vantage_strip_gallery' ) ) :
/**
 * Remove gallery.
 */
function vantage_strip_gallery( $content ) {
	preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );

	if ( ! empty( $matches ) ) {
		foreach ( $matches as $shortcode ) {
			if ( 'gallery' === $shortcode[2] ) {
				$pos = strpos( $content, $shortcode[0] );
				if ( false !== $pos ) {
					return substr_replace( $content, '', $pos, strlen( $shortcode[0] ) );
				}
			}
		}
	}

	return $content;
}
endif;

if ( ! function_exists( 'vantage_get_video' ) ) :
/**
 * Get the video from the current post.
 */
function vantage_get_video() {
	$first_url    = '';
	$first_video  = '';

	$i = 0;

	preg_match_all( '|^\s*https?://[^\s"]+\s*$|im', get_the_content(), $urls );

	foreach ( $urls[0] as $url ) {
		$i++;

		if ( 1 === $i ) {
			$first_url = trim( $url );
		}

		$oembed = wp_oembed_get( esc_url( $url ) );

		if ( ! $oembed ) continue;

		$first_video = $oembed;

		break;
	}

	return ( '' !== $first_video ) ? $first_video : false;
}
endif;

if ( ! function_exists( 'vantage_filter_video' ) ) :
/**
 * Removes the video from the page.
 */
function vantage_filter_video( $content ) {
	if ( vantage_get_video() ) {
		preg_match_all( '|^\s*https?://[^\s"]+\s*$|im', $content, $urls );

		if ( ! empty( $urls[0] ) ) {
			$content = str_replace( $urls[0], '', $content );
		}

		return $content;
	}
}
endif;

if ( ! function_exists( 'vantage_get_image' ) ) :
/**
 * Removes the first image from the page.
 */
function vantage_get_image() {
	$first_image = '';

	$output = preg_match_all( '/<img[^>]+\>/i', get_the_content(), $images );

	if ( empty( $images[0] ) ) return false;

	$first_image = $images[0][0];

	return ( '' !== $first_image ) ? $first_image : false;
}
endif;

if ( ! function_exists( 'vantage_strip_image' ) ) :
/**
 * Removes the first image from the page.
 */
function vantage_strip_image( $content ) {
	return preg_replace( '/<img[^>]+\>/i', '', $content, 1 );
}
endif;

if ( ! function_exists( 'vantage_jetpack_remove_rp' ) ) :
/**
 * Remove Jetpack Related Posts from the bottom of posts.
 */
function vantage_jetpack_remove_rp() {
	if ( class_exists( 'Jetpack' ) && class_exists( 'Jetpack_RelatedPosts' ) ) {
		$jprp = Jetpack_RelatedPosts::init();
		$callback = array( $jprp, 'filter_add_target_to_dom' );
		remove_filter( 'the_content', $callback, 40 );
	}
}
endif;
add_filter( 'wp', 'vantage_jetpack_remove_rp', 20 );

if ( ! function_exists( 'vantage_related_posts' ) ) :
/**
 * Display related posts on single posts.
 */
function vantage_related_posts( $post_id ) {
	if ( class_exists( 'Jetpack' ) && class_exists( 'Jetpack_RelatedPosts' ) ) {
		echo do_shortcode( '[jetpack-related-posts]' );
	} else {
		$categories = get_the_category( $post_id );
		if ( empty( $categories ) ) return;
		$first_cat = $categories[0]->cat_ID;
		$args=array(
			'category__in' => array( $first_cat ),
			'post__not_in' => array( $post_id ),
			'posts_per_page' => 3,
			'ignore_sticky_posts' => -1
		);
		$related_posts = new WP_Query( $args ); ?>

		<div class="related-posts-section">
			<h3 class="related-posts"><?php esc_html_e( 'Related Posts', 'vantage' ); ?></h3>
			<?php if ( $related_posts->have_posts() ) : ?>
				<ol>
					<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
						<li>
							<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail(); ?>
								<div>
									<h3 class="related-post-title"><?php the_title(); ?></h3>
									<p class="related-post-date"><?php echo get_the_date(); ?></p>
								</div>
							</a>
						</li>
					<?php endwhile; ?>
				</ol>
			<?php else : ?>
				<br /><p><?php esc_html_e( 'No related posts.', 'vantage' ); ?></p>
			<?php endif; ?>
		</div>
		<?php wp_reset_query();
	}
}
endif;
