/**
 * Main theme Javascript - (c) Greg Priday, freely distributable under the terms of the GPL 2.0 license.
 */

/* global jQuery */

jQuery(function($){
    $('body.no-js').removeClass('no-js');

    // Initialize the flex slider
    $('.entry-content .flexslider:not(.metaslider .flexslider), #metaslider-demo.flexslider').flexslider( { } );

    /* Setup fitvids for entry content and panels */
    if(typeof $.fn.fitVids !== 'undefined') {
        $('.entry-content, .entry-content .panel, .woocommerce #main' ).fitVids({ ignore: '.tableauViz' });
    }

	var isMobileDevice = $('body').hasClass('so-vantage-mobile-device'),
		isCustomizer = $('body').hasClass('so-vantage-customizer-preview'),
		isMobileNav = $('nav.site-navigation.primary').hasClass('mobile-navigation');
    if( ( !isMobileDevice && $('#scroll-to-top').hasClass('scroll-to-top') ) || ( ( isCustomizer || isMobileDevice ) && isMobileNav ) ) {

        // Everything we need for scrolling up and down.
        $(window).scroll( function(){
            if($(window).scrollTop() > 150) {
                $('#scroll-to-top').addClass('displayed');
            }
            else {
                $('#scroll-to-top').removeClass('displayed');
            }
        } );

        $('#scroll-to-top').click( function(){
            $("html, body").animate( { scrollTop: "0px" } );
            return false;
        } );
    }

    // The carousel widget
    $('.vantage-carousel').each(function(){
        var $$ = $(this);
        var wrap = $$.closest('.widget');
        var title = wrap.find('.widget-title');
        var $items = $$.find('.carousel-entry');
        var $firstItem = $items.eq(0);

        var position = 0, page = 1, fetching = false, complete = false, numItems = $items.length, itemWidth = ( $firstItem.width() + parseInt($firstItem.css('margin-right')) );

        var updatePosition = function() {
            if ( position < 0 ) {
                position = 0;
            }
            if ( position >= $$.find('.carousel-entry').length - 1 ) {
                position = $$.find('.carousel-entry').length - 1;

                // Fetch the next batch
                if( !fetching && !complete) {
                    fetching = true;
                    page++;
                    $$.append('<li class="loading"></li>');

                    $.get(
                        $$.data('ajax-url'),
                        {
                            query : $$.data('query'),
                            action : 'vantage_carousel_load',
                            paged : page
                        },
                        function (data, status){
                            var $items = $(data.html);
                            var count = $items.find('.carousel-entry').appendTo($$).hide().fadeIn().length;
                            numItems += count;
                            if(count === 0) {
                                complete = true;
                                $$.find('.loading').fadeOut(function(){
                                    $(this).remove();
                                });
                            }
                            else {
                                $$.find('.loading').remove();
                            }
                            fetching = false;
                        }
                    );
                }
            }
            $$.css('transition-duration', "0.45s");
            $$.css('margin-left', -( itemWidth * position) + 'px' );
        };

        title.find('a.previous').click( function(){
            position -= 1;
            updatePosition();
            return false;
        } );

        title.find('a.next').click( function(){
            position += 1;
            updatePosition();
            return false;
        } );

        // Setup swiping for mobile devices
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
            swipeStatus: function (event, phase, direction, distance, duration, fingerCount, fingerData) {
                if ( phase === "start" ) {
                    startPosition = -( itemWidth * position);
                    prevTime = new Date().getTime();
                    clearInterval(posInterval);
                }
                else if ( phase === "move" ) {
                    if( direction === "left" ) {
                        distance *= -1;
                    }
                    setNewPosition(startPosition + distance);
                    var newTime = new Date().getTime();
                    var timeDelta = (newTime - prevTime) / 1000;
                    velocity = (distance - prevDistance) / timeDelta;
                    prevTime = newTime;
                    prevDistance = distance;
                }
                else if ( phase === "end" ) {
                    validSwipe = true;
                    if( direction === "left" ) {
                        distance *= -1;
                    }
                    if(Math.abs(velocity) > 400) {
                        velocity *= 0.1;
                        var startTime = new Date().getTime();
                        var cumulativeDistance = 0;
                        posInterval = setInterval(function () {
                            var time = (new Date().getTime() - startTime) / 1000;
                            cumulativeDistance += velocity * time;
                            var newPos = startPosition + distance + cumulativeDistance;
                            var decel = 30;
                            var end = (Math.abs(velocity) - decel) < 0;
                            if( direction === "left" ) {
                                velocity += decel;
                            }
                            else {
                                velocity -= decel;
                            }
                            if(end || !setNewPosition(newPos)) {
                                clearInterval(posInterval);
                                setFinalPosition();
                            }
                        }, 20);
                    } else {
                        setFinalPosition();
                    }
                }
                else if( phase === "cancel") {
                    updatePosition();
                }
            }
        } );

        var setNewPosition = function(newPosition) {
            if(newPosition < 50 && newPosition >  -( itemWidth * numItems )) {
                $$.css('transition-duration', "0s");
                $$.css('margin-left', newPosition + 'px' );
                return true;
            }
            return false;
        };
        var setFinalPosition = function() {
            var finalPosition = parseInt( $$.css('margin-left') );
            position = Math.abs( Math.round( finalPosition / itemWidth ) );
            updatePosition();
        };

        // Prevent clicks when we're swiping
        $$.on('click', 'li.carousel-entry .thumbnail a', function (event) {
            if(validSwipe) {
                event.preventDefault();
                validSwipe = false;
            }
        } );
    } );

    // The menu hover effects
    $('#masthead')
        .on('mouseenter', '.main-navigation ul li', function(){
            var $$ = $(this);
            var $ul = $$.find('> ul');
            $ul.css({
                'display' : 'block',
                'opacity' : 0
            }).clearQueue().animate({opacity: 1}, 250);
            $ul.data('final-opacity', 1);
        } )
        .on('mouseleave', '.main-navigation ul li', function(){
            var $$ = $(this);
            var $ul = $$.find('> ul');
            $ul.clearQueue().animate( {opacity: 0}, 250, function(){
                if($ul.data('final-opacity') === 0) {
                    $ul.css('display', 'none');
                }
            });
            $ul.data('final-opacity', 0);
        } );

    // Hover for the menu widget in the header
    $('#header-sidebar .widget_nav_menu')
        .on('mouseenter', 'ul.menu li', function(){
            var $$ = $(this);
            var $ul = $$.find('> ul');
            $ul.finish().css('opacity', 0)
                .hide().slideDown(200)
                .animate( { opacity: 1 }, { queue: false, duration: 200 } );
        } )
        .on('mouseleave', 'ul.menu li', function(){
            var $$ = $(this);
            var $ul = $$.find('> ul');
            $ul.finish().fadeOut(150);
        } );

    // The search bar
    var isSearchHover = false;
    $(document).click(function(){
        if(!isSearchHover) {
            $('#search-icon form').fadeOut(250);
        }
    });

	// Aligning menu elements
	var mhHeight = $('.masthead-logo-in-menu').height(),
		menuItemHeight = $('.masthead-logo-in-menu .menu > .menu-item').outerHeight(),
		logoHeight = $('.masthead-logo-in-menu .logo').outerHeight();
	if( mhHeight > menuItemHeight ){
		$('.masthead-logo-in-menu .menu > .menu-item').css('margin-top', (mhHeight - menuItemHeight) / 2);
	}
	if( mhHeight > logoHeight ){
		$('.masthead-logo-in-menu .logo').css('margin-top', (mhHeight - logoHeight) / 2);
	}

    $(document)
        .on('click','#search-icon-icon', function(){
            var $$ = $(this).parent();
            $$.find('form').fadeToggle(250);
            setTimeout(function(){
                $$.find('input[name=s]').focus();
            }, 300);
        } );

    $(document)
        .on('mouseenter', '#search-icon', function(){
            isSearchHover = true;
        } )
        .on('mouseleave', '#search-icon', function(){
            isSearchHover = false;
        } );

    $(window).resize(function() {
        $('#search-icon .searchform').each(function(){
            $(this).width($(this).closest('.full-container').width());
        });
    }).resize();

    // The sticky menu
    if( ( $('nav.site-navigation.primary').hasClass('use-sticky-menu') && !isMobileDevice ) ||
        ( ( isMobileDevice || isCustomizer ) && isMobileNav ) ) {

        var $$ = $('nav.site-navigation.primary');
        var $stickyContainer = $('<div id="sticky-container"></div>');

        $stickyContainer.css('margin-left', $$.css('margin-left'));
        $stickyContainer.css('margin-right', $$.css('margin-right'));
        $stickyContainer.css('position', $$.css('position'));
        var $initTop;
        var resetStickyMenu = function(){
            if($initTop == null || typeof $initTop == "undefined") {
                $initTop = $$.offset().top;
            }
            var threshold = 0;
            if ( $('body').hasClass('admin-bar') ) {
                var adminBar = $('#wpadminbar');
                var adminBarHeight = adminBar.outerHeight();
                threshold = adminBar.css('position') == "absolute" ? 0 : adminBarHeight;
            }
            var scrollTop = $(window).scrollTop();
            var navTop = parseInt($initTop - scrollTop);//Force truncation of float value.
            if( navTop < threshold ) {
                if( ! $$.hasClass( 'sticky') ) {
                    $$.wrapAll( $stickyContainer );
                    // Work out the current position
                    $$.css({
                        'position' : 'fixed',
                        'width' : $$.parent().width(),
                        'top' : threshold,
                        'left' : $$.parent().position().left,
                        'z-index' : 998
                    }).addClass('sticky');
                } else {
                    $$.css({
                        'width': $$.parent().width(),
                        'top': threshold,
                        'left': $$.parent().position().left
                    });
                }
                $$.parent().css('height', $$.outerHeight());
            }
            else {
                if($$.hasClass('sticky')) {
                    $$.css({
                        'position': '',
                        'width': '',
                        'top': '',
                        'left': '',
                        'z-index': ''
                    }).removeClass('sticky');
                    $$.unwrap();
                    $initTop = null;
                }
            }
        };
        $(window).scroll( resetStickyMenu ).resize( resetStickyMenu );
        resetStickyMenu();
    }

    // Lets make the slider stretch.
    $('body.layout-full #main-slider[data-stretch="true"]').each(function(){
        var $$ = $(this);
        $$.find('>div').css('max-width', '100%');
        $$.find('.slides li').each(function(){
            var $s = $(this);

            // Move the image into the background
            var $img = $s.find('img.ms-default-image').eq(0);
            if(!$img.length) {
                $img = $s.find('img').eq(0);
            }

            $s.css('background-image', 'url(' + $img.attr('src') + ')');
            $img.css('visibility', 'hidden');
            // Add a wrapper
            $s.wrapInner('<div class="full-container"></div>');
            // This is because IE doesn't detect links correctly when we stretch slider images.
            var link = $s.find('a');
            if(link.length) {
                $s.mouseover(function () {
                    $s.css('cursor', 'hand');
                });
                $s.mouseout(function () {
                    $s.css('cursor', 'pointer');
                });
                $s.click(function ( event ) {
                    event.preventDefault();
                    var clickTarget = $(event.target);
                    var navTarget = clickTarget.is('a') ? clickTarget : link;
                    window.open( navTarget.attr( 'href' ), navTarget.attr( 'target' ) );
                });
            }
        });
    });

    // Resize the header widget area
    $('#header-sidebar').each(function(){
        var $$ = $(this);
        var padding = 0;
        $$.find('> aside').each(function(){
            var thisPadding = ( $$.outerHeight() - $$.find('> aside').outerHeight() ) / 2;
            if(thisPadding > padding) {
                padding = thisPadding;
            }
        });

        if(padding > 15) {
            $$.css({
                'padding-top' : padding,
                'padding-bottom' : padding
            });
        }
        else{
            padding = -padding + 15;
            $('#masthead .logo > *').css({
                'padding-top' : padding,
                'padding-bottom' : padding
            });
        }

        if( $$.hasClass('no-logo-overlay') ) {
            // This will prevent the widgets from overlaying the logo
            var autoResponsive = function(){
                $$.closest('#masthead').removeClass('force-responsive');
                var $l = $('#masthead .logo').find('h1,img');
                if( $$.offset().left < $l.offset().left + $l.outerWidth() ) {
                    $$.closest('#masthead').addClass('force-responsive');
                }
            };
            $(window).resize(autoResponsive);
            autoResponsive();
        }

    });

	$('#colophon #footer-widgets .widget_nav_menu a').each(function(){
		var $$ = $(this),
			itemDepth = $(this).parents('.sub-menu').length,
			itemPadding = ( 10 * itemDepth ) + 'px';

		$(this).css('padding-left',itemPadding);
	});

});
