
/* globals jQuery, wp, soCustomizeAdmin, confirm */

wp.customize.bind( 'ready', function( value ){
    var $ = jQuery;

    var button = null;
    $('#accordion-panel-siteorigin_theme_settings ').one('expanded', function(){
        var buttonWrapper = $("<div id='siteorigin-customizer-reset'></div>")
            .appendTo( $('#accordion-panel-siteorigin_theme_settings .accordion-section-content.description') )
            .append(
                $("<a class='reset-customizations button-secondary'></a>")
                    .html( soCustomizeAdmin.button )
                    .attr( 'href', soCustomizeAdmin.action )
            );

        buttonWrapper.find('a.reset-customizations').click(function(e){
            if( !confirm( soCustomizeAdmin.confirm ) ) {
                e.preventDefault();
            }
        });
    });


});