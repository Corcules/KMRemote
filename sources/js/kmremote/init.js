var BOARDS ; // taffy db for board
var WIDGETS ; // taffy db for board

var MODE; // current app mode, run||edit (string)

var AUTOSWITCH = false ; // in run mode switch board automaticlaly according to the current front app on mac - True /false

var PANEL; // current opened panel (string id)

var ListenDelay = 1000 ; // interval for ajax call to get current front app and finder path
var ListenApp = false ; // 
var ListenPath = false ; // 

// UNIT FOR GRID BUILDING AND GLOBAL POSITIONNING
var margeMin = 20; // minimal margin - thinking to status bar on ios
// height
var wH = $(window).height();
var nItemH = Math.floor( (wH-margeMin*2)/20 ) ;
var margesH = wH - (nItemH*20) ;
var margeH = margesH / 2 ; 
// widht
var wW = $(window).width();
var nItemW = Math.floor( (wW-margeMin*2)/20 ) ;
var margesW = wW - (nItemW*20) ;
var margeW = margesW / 2 ;


$.ajaxSetup({
    url: ajaxurl , 
    dataType : 'json',
    type:'POST',
});

function kmr_init() {
    
    // INIT FASTCLICK
    // accélère le click (délay lier à la traduction du click en touch
    // et supprime les effets de focus sur les champs de formulaire
    document.addEventListener('DOMContentLoaded', function() {
		FastClick.attach(document.body);
	}, false);

    // Adjust Menu handler position	
	$('#top-menu-panel-handler').css({
       'top'    : margeH ,
       'right'  : margeW ,
    });
    // Adjust menu position
    $('#top-menu-panel').css({
    	'marginLeft' : 0 - ( 250 + margeW - 1 ) // width of menu panel + margeW - manual adjust
	});
    // Adjust Main Menu offset
    $('#main-menu').css({
    	'top' : margeH + 40 + 12/2  // margeH + height of menu handler + half of top menu arrow height
	});

    
	activate_mode_run() ;
	
	// JQUERY AJAX DEFAULT
	$.ajaxSetup({
        url: ajaxurl , 
        dataType : 'json',
        type:'POST',
    });
	
	// LOAD DATAS
	$.ajax({
        data:{'action':'getdatas'},
        success : function(datas) {
            BOARDS = TAFFY( datas['boards'] );
            WIDGETS = TAFFY( datas['widgets'] );
            build();
        }
    });

    picker_action_reload();
    activate_check_mac_infos();
}



function build() {
        
    var data = BOARDS().get();
    var lastid; 
    if ( data.length ) {
        console.log( data ) ;
        data.forEach(function(board) {
              build_board( board );
              board_manager_new_board( board , false );
              last = board.board_id ;
        });
    }
    
    activate_board( last );
    
        
    var data = WIDGETS().get();
    if( data.length ) {
        console.log( data ) ;
        data.forEach(function(widget){
            build_widget( widget, false );
        });
    }
    
    
}



kmr_init();



// Prevent IOS keyboard to offset globally app when focus on an input by positionning the input is on the top of the panel before the focus
$('input[type="text"],textarea').on('touchstart', function(e) {
    e.stopPropagation();
    e.preventDefault();
    var self = $(this) ;
    var content = $(this).parents('.content');
    var pos  = $(this).offset().top + content.scrollTop() - 62 ;
    content.animate({scrollTop : pos } , 300 , function () {
        self.focus();
    }) ;
});







