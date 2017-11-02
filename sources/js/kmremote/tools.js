function reset_form ( which ) {
    // reset std input
    $('#panel-' + which ).find('form').get(0).reset();
    // reset hidden input
    $('#panel-' + which ).find('input[type="hidden"]').each(function() {
        // Default value
        $(this).val( $(this).attr('data-default') );
        // associated preview 
        var preview = $(this).parent().find('.preview') ; 
        preview.css({backgroundColor:''}); // color
        var icon = preview.find('i');
        if ( icon.length ) {
            icon.removeClass(); // icon
        }else{
            preview.html(''); // action
        }
    });
    // Special widget form
    $('#widget-view').find('input').first().prop('checked', true );
    $('.widget-view-icon').show();
    $('.widget-view-title,.widget-view-both').hide();
    $('#widget-view-both-position').find('input').prop('checked', false);
    
    // Special board form 
    $('#action-listen-app,#action-listen-path').removeClass('active');
    $('#switch-on-finder').hide();
    
    // scroll form to top
    $('#panel-' + which ).find('.content').scrollTop(0);
}




function open_panel ( which ) { 
    $('#panel-'+which).addClass('open')/* .find('input[type="text"]').first().focus() */;
    PANEL = which ;
}
function close_panel( which ) {
    $('#panel-'+which).removeClass('open');
    PANEL = '' ;
}



function get_macro_name( uiid ) { 
    var macroListed = $('.picker-action').find('[data-value="'+uiid+'"]') ;
    if( macroListed.length ) {
        return macroListed.html();
    }else{
        return '<i>macro not found</i>';
    }   
}