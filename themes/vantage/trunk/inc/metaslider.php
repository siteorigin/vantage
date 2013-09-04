<?php

function vantage_metaslider_themes($themes, $current){
	$themes .= "<option value='vantage' class='option flex' ".selected('vantage', $current).">".__('Vantage (Flex)', 'vantage')."</option>";
	return $themes;
}
add_filter('metaslider_get_available_themes', 'vantage_metaslider_themes', 5, 2);