// EVENTS

$('.action-cancel-board-delete').on('click', cancel_delete_board);
$('.action-confirm-board-delete').on('click', confirm_delete_board );

$('#action-panel-board-cancel').on('click', panel_board_cancel );
$('#action-panel-board-save').on('click', panel_board_save );

$('#action-listen-app').on('click' , toggle_listen_app ) ;
$('#action-listen-path').on('click' , toggle_listen_path ) ;



function populate_board_form( ) {
    // reset Form
    reset_form_board();
    // Populate
    var rq = {};
    rq['board_id'] =  parseInt( $('.board.active').attr('id').split('b')[1] , 10 ) ;
    var b = BOARDS(rq).first();
    if( b ) {
        // Input
        $.each( b , function( i , p ) {
            $('[name="'+i+'"]').val( p );
        });
        // Preview
        $('form[name="board"]').find('.input-color').each(function() {
            var v = $(this).find('input').val();
            $(this).find('.preview').css({backgroundColor:'#'+v});
        });
        $('form[name="board"]').find('.input-icon').each(function() {
            var v = $(this).find('input').val();
            $(this).find('.preview i').removeClass().addClass(v);
        });
        if(  b.board_switch_on_app == 'Finder' ) {
            $('#switch-on-finder').show();
        }
        panel_board_open();
    }else{
        // error no board found
    }
}




function panel_board_open() {
    $('#top-menu-panel').removeClass('open');
    open_panel( 'board' );
}

function panel_board_close() {
    $('#top-menu-panel').removeClass('open');
    close_panel( 'board' );
}

function panel_board_cancel( ) {
    // ref var panel
    panel_board_close();
}

function panel_board_save( ) {
    save_board('panel_board_close');
}

function new_board() {
    init_new_board();
}

function init_new_board() {
    reset_form_board();
	panel_board_open();
}


function reset_form_board( ) {
    reset_form( 'board' );
}



function toggle_listen_app() {
    if ( $(this).hasClass('active') ) {
        $(this).removeClass('active');
        ListenApp = false;
        var input = $(this).prev('input');
        if ( input.val() == "Finder" ) {
            $('#switch-on-finder').show();
            $('input[name="action-listen-path"]').val('');
        }else{
            $('#switch-on-finder').show();
        }
    }else{
        $(this).addClass('active');
        ListenApp = true;
    }
}


function toggle_listen_path() {
    if ( $(this).hasClass('active') ) {
        $(this).removeClass('active');        
        ListenPath = false;
    }else{
        $(this).addClass('active');
        ListenPath = true;
    }
}


