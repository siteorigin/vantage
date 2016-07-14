/**
 * Handles Meta Slider admin - (c) Greg Priday, freely distributable under the terms of the GPL 2.0 license.
 */
jQuery( function($){
    var currentSlide;

    var addButtonToLayered = function(){
        jQuery('.metaslider .left table .slide').has('textarea.wysiwyg').each(function(){
            var $$ = $(this);
            if( !$$.has('.prebuiltSlides').length ) {
                var button = $('<p class="prebuiltSlides">' + siteoriginMetaslider.prebuilt + '</p>');
                $$.find('.rawEdit').after(button);

                button.click( function(){
                    var $$ = $(this);
                    currentSlide = $$.closest('.slide');

                    $('#siteorigin-metaslider-prebuilt-layouts-overlay').fadeIn();
                    $('#siteorigin-metaslider-prebuilt-layouts').fadeIn();
                    return false;
                } );
            }
        });
    }
    addButtonToLayered();

    $('#siteorigin-metaslider-prebuilt-layouts-overlay').click(function(){
        $('#siteorigin-metaslider-prebuilt-layouts-overlay').hide();
        $('#siteorigin-metaslider-prebuilt-layouts').hide();
    });

    $('#siteorigin-metaslider-prebuilt-layouts .layouts .layout').click(function(){
        var $$ = $(this);
        var html = $$.data('html');

        var slideWidth = $('input[name="settings[width]"]').val();
        var slideHeight = $('input[name="settings[height]"]').val();

        // Replace the width and height attributes based on the slider size.
        html = html.replace(/\{[a-z]*\:[0-9]*\%\}/gm, function(m){
            var arr = /\{([a-z]*)\:([0-9]*)\%\}/gm.exec(m);
            if(arr[1] == 'width') m = slideWidth/100*parseFloat(arr[2]);
            else if(arr[1] == 'height') m = slideHeight/100*parseFloat(arr[2]);

            return Math.round(m);
        });
        html = html.replace(/\{rand\}/gm, function(){ return Math.floor((Math.random()*10000000)); });

        if(confirm(siteoriginMetaslider.replace)){
            currentSlide.find('textarea.wysiwyg').val(html);
            $('#siteorigin-metaslider-prebuilt-layouts-overlay').fadeOut('fast');
            $('#siteorigin-metaslider-prebuilt-layouts').fadeOut('fast');
        }

        return false;
    });

    $('#siteorigin-metaslider-prebuilt-layouts .close').click(function(){
        $('#siteorigin-metaslider-prebuilt-layouts-overlay').fadeOut('fast');
        $('#siteorigin-metaslider-prebuilt-layouts').fadeOut('fast');
        return false;
    });

    $(document).ajaxSuccess(function() {
        addButtonToLayered();
    });

} );