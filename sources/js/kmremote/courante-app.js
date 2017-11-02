var checkMacInfosTimeout ;

function getCurrentMacInfos () {
        
        // bail early 
        if ( MODE == 'run' && !AUTOSWITCH ) {
            activate_check_mac_infos();
            return;
        }
        
        if ( MODE == 'edit' ) {
            if ( !ListenApp && !ListenPath ) {
                activate_check_mac_infos();
                return;
            }
        }



        $.ajax({
        data : {action:'getcurrentmacinfos'} ,
        success : function( msg ) {
            if(  MODE == 'run' ) {
                if ( AUTOSWITCH ) {

                    var rq = {};
                    rq['board_id'] = parseInt( $('.board.active').attr('id').split('b')[1] , 10 ) ;
                    var currentBoard = BOARDS(rq).first();
                    
                    if ( msg.app == 'Finder' ) {
                        
                        // current board match > do nothing
                        if ( currentBoard.board_switch_on_app == msg.app && currentBoard.board_switch_on_path == msg.path ) {

                        }else{
                            
                            // find board matching app and path  
                            var rq = {} ;
                            rq['board_switch_on_app'] = msg.app ;
                            rq['board_switch_on_path'] = msg.path;
                            var targetBoard = BOARDS(rq).first();
                            if ( targetBoard ) {
                                
                                activate_board( targetBoard );
                                
                            }else{
                                
                                // Find board matching app only
                                var rq = {} ;
                                rq['board_switch_on_app'] = msg.app ;
                                rq['board_switch_on_path'] = '';
                                var targetBoard = BOARDS(rq).first();
                                if ( targetBoard ) {
                                    activate_board( targetBoard );
                                }
                            }
                        }
                        
                    }else{
                        
                        // If current board not match
                        if ( currentBoard.board_switch_on_app != msg.app ) {
                            var rq = {};
                            rq['board_switch_on_app'] = msg.app;
                            targetBoard = BOARDS(rq).first();
                            if ( targetBoard ) {
                                activate_board( targetBoard );
                            }
                        }
                        
                        
                    }
                }
            }
            
            if ( MODE == 'edit' ) {
                if( PANEL == 'board' ) {
                    if( ListenApp ) {
                        $('input[name="board_switch_on_app"]').val( msg.app ) ;
                    }
                    if( ListenPath ) {
                        $('input[name="board_switch_on_path"]').val( msg.path ) ;
                    }
                }
            }
            
            // next call register
            activate_check_mac_infos();
        },
    });
}

function activate_check_mac_infos() {
    clearTimeout( checkMacInfosTimeout ) ;
    checkMacInfosTimeout = setTimeout( getCurrentMacInfos , ListenDelay );
}

function desactivate_check_mac_infos( ) {
    clearTimeout( checkMacInfosTimeout ) ;
}



