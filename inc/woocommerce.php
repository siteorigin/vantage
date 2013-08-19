<?php

function vantage_woocommerce_before_single_product(){
	?><div id="primary"><?php
}
add_action('woocommerce_before_single_product', 'vantage_woocommerce_before_single_product');

function vantage_woocommerce_after_single_product(){
	?></div><?php
}
add_action('woocommerce_after_single_product', 'vantage_woocommerce_after_single_product');