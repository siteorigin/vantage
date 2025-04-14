<?php
/**
 * Deprecated functions.
 *
 * @since siteorigin-unwind 1.20.30
 *
 * @license GPL 2.0
 */

if ( ! function_exists( 'vantage_pagination' ) ) {
	/**
	 * Display the pagination
	 *
	 * @param string $pages
	 * @param int    $range
	 */
	function vantage_pagination( $pages = '', $range = 2 ) {
		$showitems = ( $range * 2 ) + 1;

		global $wp_query, $wp_rewrite;
		$paged = $wp_query->get( 'paged' );

		if ( empty( $paged ) ) {
			$paged = 1;
		}

		if ( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;

			if ( ! $pages ) {
				$pages = 1;
			}
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
				'base' => get_pagenum_link( false ) . '%_%',
			) );
			echo "</div>\n";
		}
	}
}