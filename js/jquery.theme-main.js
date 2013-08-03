/**
 * Main theme Javascript - (c) Greg Priday, freely distributable under the terms of the GPL 2.0 license.
 */
jQuery(function($){
    // Initialize the flex slider
    $('.flexslider').flexslider({});
    
    /* Setup fitvids for entry content and panels */
    $('.entry-content, .entry-content .panel' ).fitVids();
});