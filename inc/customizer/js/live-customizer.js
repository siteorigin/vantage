/**
 * (c) Greg Priday, freely distributable under the terms of the GPL 2.0 license.
 */

/* globals jQuery, wp, customizeSettings */

jQuery(function($){

    var availableFonts = {};

    $.each(customizeSettings, function(id, el){

        if(typeof el.selector === 'string') {
            el.selector = [el.selector];
        }
        else if(typeof el.selector === 'undefined') {
            el.selector = [];
        }

        $.each(el.selector, function(i, selector){

            switch( el.type ) {
                case 'color' :
                    wp.customize( id, function( value ) {
                        value.bind( function( newval ) {
                            if(typeof el.property === 'string') {
                                el.property = [el.property];
                            }
                            $.each(el.property, function(i, property){
                                $( selector ).css( property, newval );
                            });
                        } );

                    } );
                    break;

                case 'measurement' :
                    wp.customize( id, function( value ) {
                        value.bind( function( newval ) {
                            var val = newval;
                            if(typeof el.unit !== 'undefined') {
                                val = val + el.unit;
                            }

                            if(typeof el.property === 'string') {
                                el.property = [el.property];
                            }
                            $.each(el.property, function(i, property){
                                $( selector ).css( property, val );
                            });
                        } );

                    } );
                    break;
            }
        });

    });

});