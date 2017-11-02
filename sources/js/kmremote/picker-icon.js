// EVENT
// Activate picker
$('.input-icon').on('touchend', '.preview', picker_icon_open );
// Panel buttons
$('.action-icon-picker-back').on('touchend', picker_icon_save );
$('.action-icon-picker-cancel').on('touchend', picker_icon_cancel );
// Search
$('.action-icon-search').on('keypress', picker_icon_search );
// Search reset
$('.action-icon-search-reset').on('touchend', picker_icon_search_reset );
// Select icon
$('.icon-grid').on('touchend', 'div' , picker_icon_select );
// Select icon and save
$('.icon-grid').on('doubletap', 'div' , {} , picker_icon_select );


var iconInput ;
var actualIcon ;
var selectedIcon ;

function picker_icon_open( ) {
    iconInput = $(this).parent().find('input') ;
    actualIcon = iconInput.val();
    var content = $('.picker-icon').clone(true) ;
    if ( actualIcon ) {
        content.find('[data-value="'+actualIcon+'"]').addClass('selected');
    }
    $('#panel-'+PANEL).find('.picker').append( content ).addClass('open') ;
}

function picker_icon_close() {
    iconInput = '';
    actualIcon = '';
    selectedIcon = '';
    $('#panel-'+PANEL).find('.picker').html('').removeClass('open');
}

function picker_icon_save() {
    if( selectedIcon && selectedIcon != actualIcon ) {
        iconInput.val( selectedIcon );
        iconInput.parent().find('.preview i').removeClass().addClass(selectedIcon);
    }
    picker_icon_close();
}

function picker_icon_cancel() {
    picker_icon_close();
}

function picker_icon_search() {
    var v = $.trim($(this).val());
    var list = $('#panel-'+PANEL).find('.icon-grid') ;
    if( v != '' ) {
        list.find('span').hide();
        list.find('div').each(function(i,e){
            var iconName = $(this).attr('data-value');
            var reg = new RegExp( v , 'i' );
            if ( iconName.match( reg ) ) {
                $(this).show();
            }else{
                $(this).hide();
            }
        });
    }else{
        list.find('.span').show();
        list.find('.div').show();
    }
}

function picker_icon_search_reset() {
    $('#panel-'+PANEL).find('.action-icon-search').val('').trigger('keyup');
}

function picker_icon_select( e ) {
    var save = !!e.data || false ;
    if ( !$(this).hasClass('selected') ) {
        $(this).parent().find('.selected').removeClass('selected');
        selectedIcon = $(this).attr('data-value');
        $(this).addClass('selected');
    }
    if( save ) {
         picker_icon_save();
    }
}

