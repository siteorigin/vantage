<?php
/**
 * Integrates this theme with WooCommerce.
 *
 * @package vantage
 * @since 1.0
 * @license GPL 2.0
 */

function vantage_woocommerce_before_single_product(){
	?><div id="primary"><?php
}
add_action('woocommerce_before_single_product', 'vantage_woocommerce_before_single_product');

function vantage_woocommerce_after_single_product(){
	?></div><?php
}
add_action('woocommerce_after_single_product', 'vantage_woocommerce_after_single_product');