<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package vantage
 * @since vantage 1.6.4
 * @license GPL 2.0
 */

/**
 * Jetpack setup function.
 *
 */
function vantage_jetpack_setup() {
	/*
	 * Enable support for Responsive Videos.
	 * See: https://jetpack.com/support/responsive-videos/
	 */
	add_theme_support( 'jetpack-responsive-videos' );	
}
add_action( 'after_setup_theme', 'vantage_jetpack_setup' );
