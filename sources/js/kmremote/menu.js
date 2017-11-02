// EVENTS
$('#top-menu-panel-handler').on('click', menu_toggle );

$('#action-edit').on('click', {mode:'edit'}, toggle_mode);
$('#action-run').on('click', {mode:'run'}, toggle_mode);
$('#action-dynamic-board-switch-toggle').on('click', toggle_auto_switch_boards );
$('#action-new-board').on('click', new_board );
$('#action-edit-board').on('click', edit_board );
$('#action-delete-board').on('touchend', init_delete_board_current );

$('#boards-manager').on('click', '.item' , board_manager_activate_board );



/* MENU MANAGER ****************************************************************
 *                                                                             *
*******************************************************************************/
function menu_toggle() {
	if ( $('#top-menu-panel').hasClass('open') ) {
	    menu_close();
    }else {
	    menu_open();
    }
}
function menu_open() {
	$('#top-menu-panel').addClass('open');
}
function menu_close() {
	$('#top-menu-panel').removeClass('open');
}






/* MENU ITEMS ******************************************************************
 *                                                                             *
*******************************************************************************/
// AUTO SWITCH BOARDS
function toggle_auto_switch_boards( ) {
    if( $(this).is(':checked') ) {
        auto_switch_boards_on();
    }else{
        auto_switch_boards_off();
    }
}
function auto_switch_boards_on() {
    AUTOSWITCH = true;
    if(  arguments.callee.caller.name != 'toggle_auto_switch_boards'  ) {
        $('#action-dynamic-board-witch-toggle').attr('checked', true );
    }
}
function auto_switch_boards_off() {
    AUTOSWITCH = false;
    if(  arguments.callee.caller.name != 'toggle_auto_switch_boards'  ) {
        $('#action-dynamic-board-witch-toggle').attr('checked', false );
    }
}



/* MENU - MODE *****************************************************************
 *                                                                             *
*******************************************************************************/
function toggle_mode( e ) {
    if ( e.data.mode == 'run' ) {
        activate_mode_run();
    }
    if ( e.data.mode == 'edit' ) {
        activate_mode_edition();
    }
}



function activate_mode_edition() {
    MODE = 'edit' ;
    $('#top-menu-panel').find('.inner').css({
        paddingTop : margeH + 254 + 40 + 12/2 
    });
    $('body').removeClass('mode-run').addClass('mode-edit');
    makeGrid( $('.board.active') );
}



function activate_mode_run( ) {
    MODE = 'run' ;
    $('#top-menu-panel').find('.inner').css({
        paddingTop : margeH + 167 + 40 + 12/2 
    });
    $('.widget.selected').removeClass('selected');
    $('.board').find('.grid').html('');
    $('body').removeClass('mode-edit').addClass('mode-run');
}




/* MENU - NEW BOARD ************************************************************
 *                                                                             *
*******************************************************************************/
function new_board() {
    init_new_board();
}





/* MENU - EDIT BOARD ***********************************************************
 *                                                                             *
*******************************************************************************/
function edit_board() {
    populate_board_form();
}








/* MENU - DELETE BOARD *********************************************************
 *                                                                             *
*******************************************************************************/
var board2Delete;

function init_delete_board_from_manager() {
    board2Delete = $(this).attr('data-id');
	$('#confirm-delete-board').addClass('open');
}

function init_delete_board_current() {
    board2Delete = $('.board.active').attr('id').split('b')[1] ;
    $('#confirm-delete-board').addClass('open');
}

function cancel_delete_board() {
    board2Delete = '';
    $('#confirm-delete-board').removeClass('open');
}

function confirm_delete_board() {
    delete_board( board2Delete ) ;
    board2Delete = '';
	$('#confirm-delete-board').removeClass('open');
}











/* BOARDS MANAGER **************************************************************
 *                                                                             *
*******************************************************************************/
function board_manager_new_board( obj , activate ) {
    
    var m = $('<div>');
        m.addClass('item');
        m.attr('data-id', obj.board_id );
        m.html(obj.board_title ) ;
    
    if( activate ) {
        m.addClass('active');
    }
    
    
    var exist = $('#boards-manager').find('[data-id="'+obj.board_id+'"]');
    // Update 
    if ( exist.length ) { // Exist > Update
        exist.html( obj.board_title );
        
    }else{ //create
        // Insertion par ordre alpha en fonction du titre
        var items = $('#boards-manager').find('.item') ;
        var inserted = false;
        
        if(  items.length ) { 
            var inserted = false; 
            $('#boards-manager').find('.item').each(function(){
                if( !inserted ) {
                    var t = $(this).html();
                    if ( t > obj.board_title ) {
                         m.insertBefore( $(this) );
                         inserted = true;
                    }
                }
            });
        }
        if ( !inserted ) {
            $('#boards-manager').find('.section-content').append( m );
        }
    }
}


function board_manager_activate_board( ) {
    
    if ( !$(this).hasClass('active') ) {
        var i = $(this).attr('data-id');
        activate_board( i );
    }
    
    
}





