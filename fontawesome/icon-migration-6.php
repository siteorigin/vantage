<?php

/**
 * Font Awesome 4 names that version 6 folded into another icon.
 *
 * The picker offers the surviving name, so saved values are mapped onto it.
 * Without this the picker shows no selection for an icon that still renders.
 *
 * Every pair was checked in a browser to confirm both names resolve to the
 * same glyph, font family and weight, so no saved icon changes appearance.
 *
 * The two entries below the stand-in comment are the exception. Font Awesome
 * removed those icons, so each is mapped to the nearest icon that still
 * exists, in the same way the version 3 to 4 map sends beaker to flask.
 */

if ( ! function_exists( 'vantage_fontawesome_6_aliases' ) ) {
	function vantage_fontawesome_6_aliases() {
		static $aliases = array(
			'fa fa-asl-interpreting' => 'fa fa-american-sign-language-interpreting',
			'fa fa-automobile' => 'fa fa-car',
			'fa fa-battery-0' => 'fa fa-battery-empty',
			'fa fa-battery-2' => 'fa fa-battery-half',
			'fa fa-battery-3' => 'fa fa-battery-three-quarters',
			'fa fa-battery-4' => 'fa fa-battery-full',
			'fa fa-cab' => 'fa fa-taxi',
			'fa fa-chain' => 'fa fa-link',
			'fa fa-cog' => 'fa fa-gear',
			'fa fa-cogs' => 'fa fa-gears',
			'fa fa-cut' => 'fa fa-scissors',
			'fa fa-deafness' => 'fa fa-deaf',
			'fa fa-dedent' => 'fa fa-outdent',
			'fa fa-euro' => 'fa fa-eur',
			'fa fa-feed' => 'fa fa-rss',
			'fa fa-hard-of-hearing' => 'fa fa-deaf',
			'fa fa-hourglass-1' => 'fa fa-hourglass-start',
			'fa fa-hourglass-2' => 'fa fa-hourglass-half',
			'fa fa-hourglass-3' => 'fa fa-hourglass-end',
			'fa fa-institution' => 'fa fa-bank',
			'fa fa-jpy' => 'fa fa-cny',
			'fa fa-legal' => 'fa fa-gavel',
			'fa fa-mail-forward' => 'fa fa-share',
			'fa fa-mail-reply' => 'fa fa-reply',
			'fa fa-mail-reply-all' => 'fa fa-reply-all',
			'fa fa-mobile-phone' => 'fa fa-mobile',
			'fa fa-mortar-board' => 'fa fa-graduation-cap',
			'fa fa-navicon' => 'fa fa-bars',
			'fa fa-remove' => 'fa fa-close',
			'fa fa-rmb' => 'fa fa-cny',
			'fa fa-rub' => 'fa fa-rouble',
			'fa fa-ruble' => 'fa fa-rouble',
			'fa fa-shekel' => 'fa fa-ils',
			'fa fa-sheqel' => 'fa fa-ils',
			'fa fa-signing' => 'fa fa-sign-language',
			'fa fa-snapchat-ghost' => 'fa fa-snapchat',
			'fa fa-sort-asc' => 'fa fa-sort-up',
			'fa fa-sort-desc' => 'fa fa-sort-down',
			'fa fa-television' => 'fa fa-tv',
			'fa fa-times' => 'fa fa-close',
			'fa fa-turkish-lira' => 'fa fa-try',
			'fa fa-university' => 'fa fa-bank',
			'fa fa-unlink' => 'fa fa-chain-broken',
			'fa fa-unsorted' => 'fa fa-sort',
			'fa fa-usd' => 'fa fa-dollar',
			'fa fa-warning' => 'fa fa-exclamation-triangle',
			'fa fa-won' => 'fa fa-krw',
			'fa fa-yen' => 'fa fa-cny',

			// Stand-ins for icons Font Awesome removed.
			'fa fa-meanpath' => 'fa fa-search',
			'fa fa-tripadvisor' => 'fa fa-suitcase',
		);

		return $aliases;
	}
}

if ( ! function_exists( 'vantage_migrate_fontawesome_6_icon' ) ) {
	function vantage_migrate_fontawesome_6_icon( $current ) {
		$aliases = vantage_fontawesome_6_aliases();

		return isset( $aliases[ $current ] ) ? $aliases[ $current ] : $current;
	}
}
add_filter( 'vantage_fontawesome_icon_name', 'vantage_migrate_fontawesome_6_icon', 20 );
