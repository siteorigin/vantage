<?php
/**
 * The template for displaying search forms in vantage
 *
 * @package vantage
 * @since vantage 1.0
 * @license GPL 2.0
 */
?>

<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label for="search-form" class="screen-reader-text"><?php esc_html_e( 'Search for:', 'vantage' ); ?></label>
	<input type="search" name="s" class="field" id="search-form" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search', 'vantage' ); ?>"/>
</form>
