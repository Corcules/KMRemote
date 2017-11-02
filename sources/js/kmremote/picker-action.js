// EVENT
// Activate picker
$('.input-action').on('touchend', '.preview', picker_action_open );
// Panel buttons
$('.action-action-picker-back').on('touchend', picker_action_save );
$('.action-action-picker-cancel').on('touchend', picker_action_cancel );
// Search
$('.action-action-search').on('keyup', picker_action_search );
$('.action-action-search-reset').on('touchend', picker_action_search_reset );
// refresh list
$('.action-macro-list-refresh').on('touchend', picker_action_reload );
// Selection
$('.macro-list').on('touchend' , 'div' , picker_action_select_macro );
// Selection and save
$('.macro-list').on('doubletap' , 'div' , {} , picker_action_select_macro );



var inputMacro ; 
var actualmacro ;
var selectedMacroUIID ;
var selectedMacroName ;


function picker_action_open() {
    inputMacro  = $(this).parent().find('input');
    actualMacro = inputMacro.val();
    var content = $('.picker-action').clone(true) ;
    if( actualMacro ) {
        content.find('[data-value="'+actualMacro+'"]').addClass('selected');        
    }
    $('#panel-'+PANEL).find('.picker').append( content ).addClass('open') ;
}
function picker_action_close() {
    inputMacro      = '';
    selectedMacroUIID   = '';
    actualmacro     = '';
    $('#panel-'+PANEL).find('.picker').html('').removeClass('open');
}
function picker_action_save() {
    if( selectedMacroUIID && selectedMacroUIID != actualmacro ) {
        inputMacro.val( selectedMacroUIID );
        inputMacro.parent().find('.preview').html( selectedMacroName ) ;
    }
    picker_action_close();
}
function picker_action_cancel() {
    inputMacro =''; 
    selectedMacroName = '';
    selectedMacroUIID   = '';
    actualmacro     = '';
    picker_action_close();
}
// Search in macros
function picker_action_search() {
    var v = $.trim($(this).val());
    var list = $('#panel-'+PANEL).find('.macro-list') ;
    if( v != '' ) {
        list.find('.group').hide();
        list.find('.macro').each(function(i,e){
            var macroName = $(this).html();
            var reg = new RegExp( v , 'i' );
            if ( macroName.match( reg ) ) {
                $(this).show();
            }else{
                $(this).hide();
            }
        });
    }else{
        list.find('.group').show();
        list.find('.macro').show();
    }
}
// Reset macro search
function picker_action_search_reset() {
    $('#panel-'+PANEL).find('.action-action-search').val('').trigger('keyup');
}
// Get KM Macros liste
function picker_action_reload( ) {
    // store eventually current selected macro
    var currentSelectedMacro = $('#panel'+PANEL).find('.macro-list').find('.selected').attr('data-value');
    // ui loading anim
    $('.action-macro-list-refresh').addClass('loading');
    // load
    $.ajax({
        data: {'action':'macrolist'} , 
        success : function(list) {
            // minimal user time for loading
            setTimeout(function() {
                // replace content
                $('.picker-action').find('.macro-list').html(list);
                // reselect previously selected
                if ( currentSelectedMacro ) {
                    $('#panel-'+PANEL).find('.macro-list').find('[data-value="'+currentSelectedMacro+'"]').addClass('selected');
                }
                //stop loading anim
                $('.action-macro-list-refresh').removeClass('loading');
            }, 500 );
        },
    });
}
// Select a macro in list
function picker_action_select_macro( e ) {
    var save = !!e.data || false ;
    if ( !$(this).hasClass('selected') ) {
        $(this).parent().find('.selected').removeClass('selected');
        selectedMacroUIID = $(this).attr('data-value');
        selectedMacroName = $(this).html();
        $(this).addClass('selected');
    }
    if( save ) {
         picker_action_save();
    }
}

