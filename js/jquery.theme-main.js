/**
 * Main theme Javascript - (c) SiteOrigin, freely distributable under the terms of the GPL 2.0 license.
 */

/* global jQuery */

jQuery ( function( $ ) {
	$( 'body.no-js' ).removeClass( 'no-js' );

	// Initialize FlexSlider.
	$( '.entry-content .flexslider:not(.metaslider .flexslider), #metaslider-demo.flexslider, .gallery-format-slider' ).flexslider( { 
		namespace: "flex-vantage-",
	} );

	// Setup FitVids for entry content, video post format, Panels, WooCommerce pages, masthead widget area and the header sidebar.
	if ( typeof $.fn.fitVids !== 'undefined' && typeof vantage !== 'undefined' && typeof vantage.fitvids ) {
		$( '.entry-content, .entry-content .panel, .entry-video, .woocommerce #main, #masthead-widgets, #header-sidebar' ).fitVids( { ignore: '.tableauViz' } );
	}

	var isMobileDevice = $( 'body' ).hasClass( 'so-vantage-mobile-device' ),
		isCustomizer = $( 'body' ).hasClass( 'so-vantage-customizer-preview' ),
		isMobileNav = $( 'nav.site-navigation.primary' ).hasClass('mobile-navigation' );
	if ( ( ! isMobileDevice && $( '#scroll-to-top' ).hasClass( 'scroll-to-top' ) ) || ( ( isCustomizer || isMobileDevice ) ) ) {

		// Everything we need for scrolling up and down.
		$( window ).on( 'scroll', function() {
			if ( $( window ).scrollTop() > 150 ) {
				$( '#scroll-to-top' ).addClass( 'displayed' );
			} else {
				$( '#scroll-to-top' ).removeClass( 'displayed' );
			}
		} );

		$( '#scroll-to-top' ).on( 'click', function() {
			$( "html, body" ).animate( { scrollTop: "0px" } );
			return false;
		} );
	}

	// The carousel widget.
	$( '.vantage-carousel' ).each( function() {
		var $$ = $( this );
		var wrap = $$.closest( '.widget' );
		var title = wrap.find( '.widget-title' );
		var $items = $$.find( '.carousel-entry' );
		var $firstItem = $items.eq(0);

		var position = 0, page = 1, fetching = false, complete = false, numItems = $items.length, itemWidth = ( $firstItem.width() + parseInt( $firstItem.css( 'margin-right' ) ) );

		var updatePosition = function() {
			if ( position < 0 ) {
				position = 0;
			}
			if ( position >= $$.find('.carousel-entry').length - 1 ) {
				position = $$.find('.carousel-entry').length - 1;

				// Fetch the next batch.
				if ( ! fetching && ! complete ) {
					fetching = true;
					page++;
					$$.append( '<li class="loading"></li>' );

					$.get(
						$$.data('ajax-url'),
						{
							query : $$.data( 'query' ),
							action : 'vantage_carousel_load',
							paged : page
						},
						function( data, status ) {
							var $items = $( data.html );
							var count = $items.find( '.carousel-entry' ).appendTo( $$ ).hide().fadeIn().length;
							numItems += count;
							if ( count === 0 ) {
								complete = true;
								$$.find( '.loading' ).fadeOut( function() {
									$( this ).remove();
								} );
							} else {
								$$.find( '.loading' ).remove();
							}
							fetching = false;
						}
					);
				}
			}
			$$.css( 'transition-duration', "0.45s" );
			$$.css( 'margin-left', -( itemWidth * position) + 'px' );
		};

		title.find( 'a.previous' ).on( 'click', function(){
			position -= 1;
			updatePosition();
			return false;
		} );

		title.find( 'a.next' ).on( 'click', function() {
			position += 1;
			updatePosition();
			return false;
		} );

		// Setup swiping for mobile devices.
		var validSwipe = false;
		var prevDistance = 0;
		var startPosition = 0;
		var velocity = 0;
		var prevTime = 0;
		var posInterval;
		$$.swipe( {
			excludedElements: "",
			triggerOnTouchEnd: true,
			threshold: 75,
			swipeStatus: function( event, phase, direction, distance, duration, fingerCount, fingerData ) {
				if ( phase === "start" ) {
					startPosition = -( itemWidth * position );
					prevTime = new Date().getTime();
					clearInterval( posInterval );
				} else if ( phase === "move" ) {
					if ( direction === "left" ) {
						distance *= -1;
					}
					setNewPosition( startPosition + distance );
					var newTime = new Date().getTime();
					var timeDelta = (newTime - prevTime) / 1000;
					velocity = (distance - prevDistance) / timeDelta;
					prevTime = newTime;
					prevDistance = distance;
				} else if ( phase === "end" ) {
					validSwipe = true;
					if ( direction === "left" ) {
						distance *= -1;
					}
					if ( Math.abs( velocity ) > 400 ) {
						velocity *= 0.1;
						var startTime = new Date().getTime();
						var cumulativeDistance = 0;
						posInterval = setInterval( function() {
							var time = (new Date().getTime() - startTime) / 1000;
							cumulativeDistance += velocity * time;
							var newPos = startPosition + distance + cumulativeDistance;
							var decel = 30;
							var end = ( Math.abs( velocity ) - decel) < 0;
							if ( direction === "left" ) {
								velocity += decel;
							} else {
								velocity -= decel;
							}
							if ( end || !setNewPosition( newPos ) ) {
								clearInterval(posInterval);
								setFinalPosition();
							}
						}, 20 );
					} else {
						setFinalPosition();
					}
				} else if( phase === "cancel") {
					updatePosition();
				}
			}
		} );

		var setNewPosition = function( newPosition ) {
			if ( newPosition < 50 && newPosition > -( itemWidth * numItems ) ) {
				$$.css( 'transition-duration', "0s" );
				$$.css( 'margin-left', newPosition + 'px' );
				return true;
			}
			return false;
		};
		var setFinalPosition = function() {
			var finalPosition = parseInt( $$.css( 'margin-left' ) );
			position = Math.abs( Math.round( finalPosition / itemWidth ) );
			updatePosition();
		};

		// Prevent clicks when we're swiping.
		$$.on( 'click', 'li.carousel-entry .thumbnail a', function( event ) {
			if ( validSwipe ) {
				event.preventDefault();
				validSwipe = false;
			}
		} );
	} );

	// Add keyboard access to the menu.
	$( '.menu-item' ).children( 'a' ).on( 'focusin', function() {
		$( this ).parents( 'li' ).addClass( 'focus' );
	} );
	// Click event fires after focus event.
	$( '.menu-item' ).children( 'a' ).on( 'click', function() {
		$( this ).parents( 'li' ).removeClass( 'focus' );
	} );
	$( '.menu-item' ).children( 'a' ).on( 'focusout', function() {
		$( this ).parents( 'li' ).removeClass( 'focus' );
	} );

	// Hover for the menu widget in the header
	$( '#header-sidebar .widget_nav_menu', '#masthead-widgets .widget_nav_menu' )
		.on('mouseenter', 'ul.menu li', function() {
			var $$ = $( this );
			var $ul = $$.find( '> ul' );
			$ul.finish().css( 'opacity', 0 )
				.hide().slideDown( 200 )
				.animate( { opacity: 1 }, { queue: false, duration: 200 } );
		} )
		.on ('mouseleave', 'ul.menu li', function() {
			var $$ = $( this );
			var $ul = $$.find( '> ul' );
			$ul.finish().fadeOut( 150 );
		} );

	// The search bar.
	var isSearchHover = false;
	$( document ).on( 'click', function() {
		if ( ! isSearchHover ) {
			$( '#search-icon form' ).fadeOut( 250 );
		}
	} );

	// Check the device that is being used.
	var deviceAgent = navigator.userAgent.toLowerCase();

	// Open and focus the search form
	$( document )
		.on( 'click keydown', '#search-icon-icon', function( e ) {
			if ( e.type == 'keydown' ) {
				if ( e.keyCode !== 13 ){
					return;
				}
				e.preventDefault();
			}
			var $$ = $( this ).parent();
			$$.find( 'form' ).fadeToggle( 250 );
			if ( deviceAgent.match( /(iPad|iPhone|iPod)/i ) ) {
				$$.find( 'input[type="search"]' ).trigger( 'focus' );
			} else {
				setTimeout( function() {
					$$.find( 'input[type="search"]' ).trigger( 'focus' );
				}, 300 );
			}
		} );

	$( document ).on( 'keyup', function( e ) {
		if ( e.keyCode == 27 ) { // Escape key maps to keycode `27`.
			$( '#search-icon form' ).fadeOut( 250 );
		}
	} );

	$( document )
	.on( 'mouseenter', '#search-icon', function() {
		isSearchHover = true;
	} )
	.on( 'mouseleave', '#search-icon', function() {
		isSearchHover = false;
	} );

	$( window ).on( 'resize', function() {
		$( '#search-icon .searchform' ).each( function() {
			$( this ).width( $( this ).closest( '.full-container' ).width() );
		} );
	} ).trigger( 'resize' );

	// The sticky menu.
	if ( ( $( 'nav.site-navigation.primary' ).hasClass( 'use-sticky-menu' ) && !isMobileDevice ) ||
		( ( isMobileDevice || isCustomizer ) && isMobileNav ) ) {

		var $$ = $( 'nav.site-navigation.primary' );
		var $initTop;
		var isBoxedMega = $( 'body.mega-menu-primary.layout-boxed' ).length;
		var boxedMegaWidth;
		var resetStickyMenu = function() {
			if ( ! $$.hasClass( 'sticky' ) ) {
				$initTop = $$.offset().top;
				boxedMegaWidth = $$.width();
			}
			var threshold = 0;
			var $body = $( 'body' );
			if ( $body.hasClass( 'admin-bar' ) ) {
				threshold = $( '#wpadminbar' ).css( 'position' ) == 'absolute' ? 0 : $( '#wpadminbar' ).outerHeight();
			}
			var navTop = parseInt( $initTop - $( window ).scrollTop() ); // Force truncation of float value.
			if ( navTop < threshold ) {
				$$.addClass( 'sticky' );
				$body.addClass( 'sticky-menu' );
				$( '#masthead' ).css( 'padding-bottom', $$.innerHeight() + 'px' );

				if ( isBoxedMega ) {
					$$.width( boxedMegaWidth );
				}
			} else if ( $body.hasClass( 'sticky-menu' ) ) {
				$( '#masthead' ).css( 'padding-bottom', 0 );
				$$.removeClass( 'sticky' );
				$body.removeClass( 'sticky-menu' );

				if ( isBoxedMega ) {
					$$.width( 'auto' );
				}
			}
		};
		$( window ).on( 'scroll resize', resetStickyMenu );
		resetStickyMenu();
	}

	// Lets make the slider stretch.
	$( 'body.layout-full #main-slider[data-stretch="true"]' ).each( function() {
		var $$ = $( this );
		$$.find( '>div' ).css( 'max-width', '100%' );
		$$.find( '.slides li' ).each( function() {
			var $s = $( this );

			// Move the image into the background.
			var $img = $s.find( 'img.ms-default-image' ).eq( 0 );
			if ( ! $img.length ) {
				$img = $s.find( 'img' ).eq( 0 );
			}

			$s.css( 'background-image', 'url(' + $img.attr( 'src' ) + ')' );
			$img.css( 'visibility', 'hidden' );
			// Add a wrapper.
			$s.wrapInner( '<div class="full-container"></div>' );
			// This is because IE doesn't detect links correctly when we stretch slider images.
			var link = $s.find( 'a' );
			if ( link.length ) {
				$s.on( 'mouseenter', function() {
					$s.css('cursor', 'hand');
				} );
				$s.on( 'mouseout', function() {
					$s.css( 'cursor', 'pointer' );
				} );
				$s.on( 'click', function( event ) {
					event.preventDefault();
					var clickTarget = $(event.target);
					var navTarget = clickTarget.is( 'a' ) ? clickTarget : link;
					window.open( navTarget.attr( 'href' ), navTarget.attr( 'target' ) );
				} );
			}
		} );
	} );

	// Resize the header widget area.
	$( '#header-sidebar' ).each( function() {
		var $$ = $( this );

		if ( $$.hasClass( 'no-logo-overlay' ) ) {
			// This will prevent the widgets from overlaying the logo.
			var autoResponsive = function() {
				$$.closest('#masthead').removeClass( 'force-responsive' );
				var $l = $( '#masthead .logo' ).find( 'h1, img' );
				if ( $$.offset().left < $l.offset().left + $l.outerWidth() ) {
					$$.closest( '#masthead' ).addClass( 'force-responsive' );
				}
			};
			$( window ).on( 'resize', autoResponsive );
			autoResponsive();
		}

	} );

	$( '#colophon #footer-widgets .widget_nav_menu a' ).each( function() {
		var $$ = $( this ),
			itemDepth = $( this ).parents( '.sub-menu' ).length,
			itemPadding = ( 10 * itemDepth ) + 'px';

		$( this ).css( 'padding-left', itemPadding );
	} );

} );
