( function( $ ){
	$(document).ready(function($) {
		$('input.vantage-color-field').wpColorPicker();
	});
	$(document).on( "panelsopen", function() {
		$('input.vantage-color-field').wpColorPicker();
	});
	$(document).on( "widget-added", function() {
		$('input.vantage-color-field').wpColorPicker();
	});
	$(document).on( "widget-updated", function() {
		$('input.vantage-color-field').wpColorPicker();
	});
}( jQuery ) );
