// EVENT
// Activate picker
$('.input-color').on('touchend', '.preview', picker_color_open );
// Panel buttons
$('.action-color-picker-back').on('touchend', picker_color_save );
$('.action-color-picker-cancel').on('touchend', picker_color_cancel );
// Select color
$('.color-grid').on('touchend', 'div' , picker_color_select );
// Select color and save
$('.color-grid').on('doubletap', 'div' , {} , picker_color_select );


var colorInput;
var actualColor;
var selectedColor;


function picker_color_open() {
    colorInput  = $(this).parent().find('input') ;
    actualColor = colorInput.val() ;
    var content = $('.picker-color').clone(true) ;
    if ( actualColor ) {
        content.find('[data-value="'+actualColor+'"]').addClass('selected');
    }
    $('#panel-'+PANEL).find('.picker').append( content ).addClass('open') ;
}

function picker_color_close() {
    colorInput      = '';
    actualColor     = '';
    selectedColor   = '';
    $('#panel-'+PANEL).find('.picker').html('').removeClass('open');
}

function picker_color_save() {
    if( selectedColor && selectedColor != actualColor ) {
        colorInput.val( selectedColor );
        colorInput.parent().find('.preview').css({backgroundColor:'#'+selectedColor});
    }
    picker_color_close();
}

function picker_color_cancel() {
    picker_color_close();
}


function picker_color_select( e ) {
    var save = !!e.data || false ;
    if ( !$(this).hasClass('selected') ) {
        $(this).parent().find('.selected').removeClass('selected');
        selectedColor = $(this).attr('data-value');
        $(this).addClass('selected');
    }
    if( save ) {
         picker_color_save();
    }
}