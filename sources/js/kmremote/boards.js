function save_board() {
    var callback = (arguments.length) ? arguments[0] : false ;
	var datas = $('form[name="board"]').serialize();
    $.ajax({
        data : datas, 
        success : function( boarddatas ) {
            
            boarddatas.board_id = parseInt( boarddatas.board_id , 10) ;
            
            // Update local db
            var rq = {};
            rq['board_id'] = boarddatas.board_id ;
            var b = BOARDS(rq).first();
            if( b ) {
                BOARDS(rq).update( boarddatas ) ;
            }else{
                BOARDS.insert(boarddatas);
            }
            
            // build board html
            build_board( boarddatas );
            
            board_manager_new_board( boarddatas , false ) ;
            
            activate_board( boarddatas.board_id ) ;
            
            if ( callback ) {
                window[callback]();
            }
        }
    });
}



function build_board( obj ) {
    
    var $b = $('#b'+obj.board_id) ;
    
    if( ! $b.length ) { // create 
    	
    	var board = $('<div>');
    		board.attr('id','b'+obj.board_id);
    		board.addClass('board');
    		board.css({
                    'top'    : margeH ,
                    'bottom' : margeH ,
                    'left'   : margeW ,
                    'right'  : margeW ,
                });
                
        var grid = $('<div>');
            grid.addClass('grid');
            
        board.append(grid);
    	var $b = board.appendTo( $('#boards') ) ; 
    	
	}
	
	// background color 
	if ( obj.board_background_color ) {
    	var bright = tinycolor(obj.board_background_color).getBrightness() ;
        if( bright > 200 ) {
            $b.addClass('bright');
        }else{
            $b.removeClass('bright');
        }
    }else{ // defaut #ffffff
        $b.addClass('bright');
    }
}





function delete_board( boardid ) {
    $.ajax({
       data : {action:'deleteboard',pid:boardid},
       success : function( msg ) {
           
            var board =  $('#b'.boardid) ;
            
            // remove from locals dbs
            var rq = {} ;
            rq['board_id'] = parseInt( boardid , 10 ) ;
            BOARDS(rq).remove();
            WIDGETS(rq).remove();
            
            //remove board in board manager
            $('#boards-manager').find('[data-id="'+boardid+'"]').remove();
            
            // define a new active board
            if(  board.hasClass('active') ) {
                var i = '';
                var prev = board.prev('.board');
                if ( prev.length ) {
                    i = prev.attr('id').split('b')[1];
                }else{
                    var next = board.next('.board');
                    if( next.length ) {
                        i = prev.attr('id').split('b')[1];
                    }
                }
                if ( i ) {
                    activate_board( i );
                }
            }
            
            // remove BOARD HTML 
            board.remove();
            
       }
    });
}



function activate_board( which ) {
    
    // determine board
    var board ;
    if(  typeof which == 'object' ) {
        board = which ;        
    }else{
        var rq = {};
        rq['board_id'] = parseInt(which,10) ;
        board = BOARDS(rq).first();
    }
    
    // background color 
    var color = 'ffffff';    
    color = board.board_background_color || 'ffffff' ;
    $('#boards').css({backgroundColor:'#'+color});
    
    // board
    $('#boards').find('.active').removeClass('active');    

    $('#b'+board.board_id).addClass('active');
    if ( MODE == 'edit' ) {
        makeGrid( $('#b'+board.board_id) ) ;
    }
    // board manager
    $('#boards-manager').find('.active').removeClass('active');
    $('#boards-manager').find('[data-id="'+board.board_id+'"]').addClass('active');
}














