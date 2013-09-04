jQuery(function($){
    $('#metaslider_demo').flexslider({
        slideshowSpeed:8000,
        animation:"fade",
        controlNav:false,
        directionNav:true,
        pauseOnHover:true,
        direction:"horizontal",
        reverse:false,
        animationSpeed:600,
        prevText:"<",
        nextText:">",
        easing:"easeInQuad",
        slideshow:true,
        before: function() {
            jQuery('#metaslider_demo li:not(".flex-active-slide") .animated').each(function(index) {
                var el = $(this);
                var cloned = el.clone();
                el.before(cloned);
                $(this).remove();
            });
        },
        useCSS:false
    });

    function metaslider_scaleLayers() {
        var orig_width = jQuery('#metaslider_demo .msDefaultImage').attr('width');
        var new_width  = jQuery('#metaslider_demo').width();

        if (parseFloat(new_width) >= parseFloat(orig_width)) {
            return;
        }

        jQuery('#metaslider_demo .msHtmlOverlay').each(function() {
            var multiplier = parseFloat(new_width) / parseFloat(orig_width);
            var percentage = multiplier * 100;

            jQuery('.layer', jQuery(this)).each(function() {
                var layer_width  = parseFloat(jQuery(this).attr('data-width'));
                var layer_height = parseFloat(jQuery(this).attr('data-height'));
                var layer_top    = parseFloat(jQuery(this).attr('data-top'));
                var layer_left   = parseFloat(jQuery(this).attr('data-left'));

                jQuery(this).css('width',       Math.round(layer_width  * multiplier) + 'px');
                jQuery(this).css('height',      Math.round(layer_height * multiplier) + 'px');
                jQuery(this).css('top',         Math.round(layer_top    * multiplier) + 'px');
                jQuery(this).css('left',        Math.round(layer_left   * multiplier) + 'px');
                jQuery(this).css('font-size',   Math.round(percentage) + '%');
                jQuery(this).css('line-height', Math.round(percentage) + '%');

                var content_padding = parseFloat($('.content', $(this)).attr('data-padding'));
                jQuery('.content', $(this)).css('padding', Math.round(content_padding * multiplier) + 'px');
            });
        });
    }

    jQuery(window).resize(function(){
        metaslider_scaleLayers();
    });
    metaslider_scaleLayers();
});