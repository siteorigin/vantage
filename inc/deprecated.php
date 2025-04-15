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
		echo "<div class='pagination'>";
		echo paginate_links( array(
			'mid_size' => $showitems,
		) );
		echo "</div>\n";
	}
}
