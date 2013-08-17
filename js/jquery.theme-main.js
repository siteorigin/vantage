/**
 * Main theme Javascript - (c) Greg Priday, freely distributable under the terms of the GPL 2.0 license.
 */
jQuery(function($){
    $('body.no-js').removeClass('no-js');

    // Initialize the flex slider
    $('.flexslider').flexslider({});
    
    /* Setup fitvids for entry content and panels */
    $('.entry-content, .entry-content .panel' ).fitVids();

    // Everything we need for scrolling up and down.

    $(window).scroll( function(){
        if($(window).scrollTop() > 150) $('#scroll-to-top').addClass('displayed');
        else $('#scroll-to-top').removeClass('displayed');
    } );

    $('#scroll-to-top').click( function(){
        $("html, body").animate( { scrollTop: "0px" } );
        return false;
    } );

    // The carousel element
    $('.vantage-carousel').each(function(){
        var $$ = $(this);
        var wrap = $$.closest('.widget');
        var title = wrap.find('.widget-title');

        var position = 0, page = 1, fetching = false, complete = false;

        var updatePosition = function() {
            if ( position < 0 ) position = 0;
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
                            if(count == 0) {
                                complete = true;
                                $$.find('.loading').fadeOut(function(){$(this).remove()});
                            }
                            else {
                                $$.find('.loading').remove();
                            }
                            fetching = false;
                        }
                    )
                }
            }
            $$.css('margin-left', (-257*position) + 'px' );

            // Load the next batch
        };

        title.find('a.previous').click( function(){
            position -= 2;
            updatePosition();
            return false;
        } );

        title.find('a.next').click( function(){
            position += 2;
            updatePosition();
            return false;
        } );
    });

    // The search bar
    $('#search-icon').mouseenter( function(){
        var $$ = $(this);
        setTimeout(function(){
            $$.find('input[name=s]').focus();
        }, 350);

    } );

    // The sticky menu
    var $mc = null;
    var resetStickyMenu = function(){
        var $$ = $('nav.site-navigation.primary');

        // Work out the current position
        if($$.position().top <= $(window).scrollTop()) {

            if($mc == null){
                $mc = $$;
                $$ = $$.clone().insertBefore($$);

                $mc.css({
                    'position' : 'fixed',
                    'width' : $$.outerWidth(),
                    'top' : 0,
                    'left' : $$.position().left,
                    'z-index' : 1001
                }).addClass('sticky').insertAfter($$);
            }
        }
        else {
            if($mc !== null){
                $mc.remove();
                $mc = null;
            }
        }
    }
    $(window).scroll( resetStickyMenu ).resize( resetStickyMenu );
    resetStickyMenu();
});