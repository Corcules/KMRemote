// EVENT
// Panel buttons
$('#action-panel-widget-cancel').on('click', panel_widget_cancel );
$('#action-panel-widget-save').on('click', panel_save_widget );
$('#action-widget-delete').on('click', panel_delete_widget ) ;


$('input[name="widget_view"]').on('click', widget_view_option );




function populate_widget_form( ) {
    reset_form_widget();
    var rq = {} ;
    rq['widget_id'] = parseInt( $('.widget.selected').attr('id').split('w')[1], 10 ) ;
    var w = WIDGETS(rq).first();
    if( w ) {
        $.each( w , function( i , p ) {
            var input = $('[name="'+i+'"]') ;
            if( input.length ) {
                var tag = input.get(0).tagname ;
                var type = input.attr('type');
                if( type != 'radio' ){
                    input.val( p );
                }else{
                    input.attr('checked', false );
                    input.filter(function() { return $(this).val() == p ; }).attr('checked', true );
                }
            }
        });
        $('form[name="widget"]').find('.input-color').each(function() {
            var v = $(this).find('input').val();
            $(this).find('.preview').css({backgroundColor:'#'+v});
        });
        $('form[name="widget"]').find('.input-icon').each(function() {
            var v = $(this).find('input').val();
            $(this).find('.preview i').removeClass().addClass(v);
        });
        $('form[name="widget"]').find('.input-action').each(function(){
            var uiid = $(this).find('input').val();
            var label = '' ;
            if ( uiid ) {
                label = get_macro_name( uiid ) ;
            }
            $(this).find('.preview').html( label );
        });
        widget_view_option();
        panel_widget_open();
    }else{
	    
        // error widget not found
    }
}







// Reset and prepare widget form
function init_new_widget(starCol , startRow , endCol , endRow ) {
    
    reset_form_widget();
    
    $('.widget.selected').removeClass('selected');
    
    var form = $('#panel-widget').find('form');
    
    // Board id
    var boardid = $('.board.active').attr('id').split('b')[1];
    form.find('input[name="board_id"]').val( boardid ) ;
        
    // Coords
    form.find('input[name="widget_sC"]').val(starCol);
    form.find('input[name="widget_sR"]').val(startRow);
    form.find('input[name="widget_eC"]').val(endCol);
    form.find('input[name="widget_eR"]').val(endRow);

    panel_widget_open();    
}

function reset_form_widget( ) {
    reset_form( 'widget' );
}

function panel_widget_open ( ) {
   open_panel( 'widget' );
}

function panel_widget_close( ) {
    $('.grid-unit').removeClass('on');
    close_panel( 'widget' );
}
    
function panel_widget_cancel( ) {
    panel_widget_close();
}



// Mode view widget
function widget_view_option( ) {
    var v = $('input[name="widget_view"]:checked').val() ;
    switch( v ) {
        case 'view-icon' : 
            $('.widget-view-icon').show();
            $('.widget-view-title').hide();
            $('.widget-view-both').hide();
            break;
        case 'view-title' : 
            $('.widget-view-icon').hide();
            $('.widget-view-title').show();
            $('.widget-view-both').hide();
            break;
        case 'view-both' :
            $('.widget-view-icon').show();
            $('.widget-view-title').show();
            $('.widget-view-both').show();
            break; 
    }
}



function panel_save_widget() {
    save_widget('panel_widget_close');
}

function panel_delete_widget() {
    var wid = $('input[name="widget_id"]').val();
    delete_widget( wid , 'panel_widget_close' );
}























