/**
 * A jQuery mobile navigation.
 *
 * @author SiteOrigin <support@siteorigin.com>
 * @copyright SiteOrigin 2012-2019
 * @license Dual GPL, MIT - Which ever works for you.
 */
jQuery( function ( $ ) {

    $.fn.mnShowFrame = function(){
        var $$ = $(this);
        $$
            .css({right: $( document ).width()})
            .show()
            .animate(
                {right: 0},
                'fast',
                function(){
                    $( window ).trigger( 'resize' );
                }
            );


        return $$;
    };

    $.fn.mnHideFrame = function(){
        var $$ = $(this);
        $$
            .add('.mobile-nav-frame')
            .css({right: 0})
            .animate(
            {right: $( document ).width()},
            'fast',
            function(){
                $(this).hide();
                $( window ).trigger( 'resize' );
            }
        );

        $('body').animate({'padding-left': 0}, 'fast');
    };

    var doneIds = [];
    $('.so-mobilenav-standard').each(function(){
        var id = $(this).data('id');
        if(typeof doneIds[id] != 'undefined') return true;
        else {
            doneIds[id] = true;
        }

        var $nav = $(this).next();
        var $mnav = $('#so-mobilenav-mobile-'+id).next();
        var frame;

        $(document).on('click', 'a.mobilenav-main-link[data-id="' + id + '"]', function (event) {
            event.preventDefault();

            if ( frame == null ) {
                // Create the frame if we haven't already
                frame = $( '<div class="mobile-nav-frame"><div class="title"><h3>' + mobileNav.text.navigate + '</h3></div><div class="slides"><div class="slides-container"></div></div></div>' ).appendTo( 'body' );
                frame.find( '.title' )
                    .prepend( '<a href="#" class="back"><i class="fa fa-long-arrow-left"></i></a><a href="#" class="close">' + mobileNav.mobileMenuClose + '</a>' )

                // Create and insert the search form if enabled
                if( mobileNav.search ) {
                    $(
                        "<form method='get' action='" + mobileNav.search.url + "' class='search'>" +
                        "<input type='search' placeholder='" + mobileNav.search.placeholder + "' results='5' name='s' />" +
                        "<input type='submit' class='search-submit' /> " +
                        "</form>"
                    ).insertAfter(frame.find('.title'));
                }

                frame.find( '.close' ).on( 'click', function(event) {
                    event.preventDefault();
                    frame.mnHideFrame();
                } );

                $( window ).on( 'resize', function () {
                    if ( !frame.is( ':visible' ) ) return;

                    frame.hide();
                    frame.width( $(window).width() );
                    frame.show();
                } );

                $( 'body' ).on( 'orientationchange', function () {
                    $( window ).trigger( 'resize' );
                } );

                activeSlide = null;
                showSlide = function ( i ) {

                    frame.find( '.slides-container .slide' ).hide();
                    activeSlide = frame.find( '.slides-container .slide' ).eq( i ).show();
                    if ( i == 0 ) frame.find( 'a.back' ).hide();
                    else frame.find( 'a.back' ).show();

                    // Change the title
                    if ( i != 0 ) {
                        frame.find( '.title h3' ).html( activeSlide.data( 'title' ) );
                    }
                    else {
                        frame.find( '.title h3' ).html( mobileNav.text.navigate );
                    }
                }

                frame.find( 'a.back' ).on( 'click', function() {
                    var parent = activeSlide.data( 'parent-slide' );
                    if ( parent != undefined ) {
                        showSlide( parent );
                    }

                    return false;
                } );

                var createMenu = function ( root ) {
                    var slide = $( '<div class="slide"><ul class="mobile"></ul></div>' ).appendTo( frame.find( '.slides-container' ) );
                    var link;
                    root.find( '> li' ).each( function () {
                        var $$ = $( this ),
                            standardMenuItem = $$.find( '> a' ).html();

                        if ( standardMenuItem ) {
                            link = $$.find( '> a' );
                            var ln = $( '<a></a>' )
                                .html( link.html() )
                                .attr( 'href', link.attr( 'href' ) )
                                .addClass( 'link' );

                                // If enabled, open menu item in new window.
                                if ( link.attr( 'target' ) ) {
                                    ln.attr( {
                                        target: link.attr( 'target' ),
                                        rel: link.attr( 'rel' )
                                    } );
                                }
                        } else {
                            var ln = $$.html();
                        }
                        var li = $( '<li></li>' ).append( ln ).addClass( $$.attr( 'class' ) );

                        // Account for menu items with sub menus and menu items set to close links
                        if ( standardMenuItem ) {
                            li.find( 'a' ).not( '.next' ).on( 'click', 
                                function( e ) {
                                    if ( $( this ).attr( 'href' ) === 'undefined' ) {
                                        frame.mnHideFrame();
                                    }
                                }
                            );


                            if ( $$.find( '> ul' ).length > 0 ) {
                                var next = $( '<a href="#" class="next"><i class="fa fa-chevron-right"></i></a>' );
                                li.prepend( next );

                                var child = $$.find( '> ul' ).eq( 0 );
                                var childSlide = createMenu( child );

                                childSlide.data( 'parent-slide', slide.index() );
                                childSlide.data( 'title', ln.html() );

                                li.find( 'a.next' ).on( 'click', function () {
                                    showSlide( childSlide.index() );
                                    return false;
                                } );
                            }
                        }

                        slide.find( 'ul' ).append( li );
                    } );

                    return slide;
                }

                createMenu( $nav.find( 'ul' ).eq( 0 ) );
                showSlide( 0 );
            }
            
            // Attach .click All non link menu items and hash links (#, #example).
            $( '.mobile-nav-frame .mobile a[href*="#"].link, .mobile-nav-frame .mobile a:not([href])' ).on( 'click', function() {
                // Check for .next and if there is one, open the sub menu
                if( $( this ).prev( '.next' ).length ) {
                    $( this ).prev( '.next' ).trigger( 'click' );
                } else {
                    // Close Mobile Menu
                    frame.mnHideFrame();
                }
            } );

            $( window ).trigger( 'resize' );
            frame.mnShowFrame();

            showSlide( 0 );

            return false;
        } );
    });


} );
