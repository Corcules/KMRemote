// Edit
$('#boards').on('taphold', '.widget', focus_widget ) ;
$('#boards').on('taphold', '.selected', deselect_widget );
$('#boards').on('tap', '.selected', edit_widget );

// Empèche le panel widget de s'ouvrir lorsqu'on clique sur les resizer
$('#boards').on('tap', '.resizer', function(e) { e.stopPropagation(); e.preventDefault(); });

// run 
$('#boards').on('tap', '.widget', do_widget_macro ) ;




//var occupiedGrid = [];




function save_widget( ) {
    
    var callback = (arguments.length) ? arguments[0] : false ;
    
    var datas = $('form[name="widget"]').serialize();
    
    $.ajax({
        data : datas ,
        success : function( widgetdatas ) {
            
            widgetdatas.widget_id = parseInt( widgetdatas.widget_id, 10 ) ;
            
            // Update local db
            var rq = {};
            rq['widget_id'] = widgetdatas.widget_id  ;
            var w = WIDGETS(rq).first();
            if( w ) {
                WIDGETS(rq).update( widgetdatas ) ;
            }else{
                WIDGETS.insert(widgetdatas);
            }
            
            // build widget html
            build_widget( widgetdatas , true );

            if ( callback ) {
                window[callback]();
            }
        },
    });
}


/*

function populateOccupiedGrid( sR , sC , eR , eC ) {
    var row = sR ;
    for( row ; row <= eR ; row++ ) {
        var col = sC ;
        for( col ; col <= eC ; col++ ) {
            if(  $.inArray( row+'_'+col ,  occupiedGrid ) == -1 ) {
                occupiedGrid.push(row+'_'+col) ;
            }
        }
    }
}
function deleteFromOccupiedGrid( sR , sC , eR, eC ) {
    var row = sR ;
    for( row ; row <= eR ; row++ ) {
        var col = sC ;
        for( col ; col <= eC ; col++ ) {
            occupiedGrid.splice( occupiedGrid.indexOf(row+'_'+col) , 1 ) ;
        }
    }
    
}
*/


function build_widget( obj, activate  ) {
    

    //populateOccupiedGrid( parseInt(obj.widget_sR, 10) , parseInt(obj.widget_sC,10) , parseInt(obj.widget_eR,10), parseInt(obj.widget_eC,10) ) ;

    var $w = $('#w'+obj.widget_id);
    
    if ( ! $w.length ) { // create
    
        var t = 20* parseInt(obj.widget_sR, 10) - 20 ;
        var l = 20* parseInt(obj.widget_sC, 10) - 20 ;
        var w = (parseInt(obj.widget_eC,10) - parseInt(obj.widget_sC,10) + 1) * 20 ;
        var h = (parseInt(obj.widget_eR,10) - parseInt(obj.widget_sR,10) + 1) * 20 ;
    	
    	    
        var nw = $('<div>');
        // id
        nw.attr('id','w'+obj.widget_id);
        nw.addClass('widget');
        if( activate ) {
            nw.addClass('selected');
        }
        // positionnement
        nw.css({
            'top' : t ,
            'left' : l ,
            'width' : w ,
            'height' : h 
        });
        // ref position
/*
        nw.attr('data-sR' , obj.widget_sR ) ;
        nw.attr('data-sC' , obj.widget_sC ) ;
        nw.attr('data-eR' , obj.widget_eR ) ;
        nw.attr('data-eC' , obj.widget_eC ) ;
*/

        // move
        var hmv = $('<div>');
        hmv.addClass('handler');
        hmv.addClass('handler-move');
        nw.append( hmv ) ;
        
        // resizer
        var rzt = $('<div>');
        rzt.addClass('resizer');
        rzt.addClass('resizer-top');
        rzt.addClass('ui-resizable-handle');
        rzt.addClass('ui-resizable-n');
        nw.append( rzt ) ;
        
        var rzr = $('<div>');
        rzr.addClass('resizer');
        rzr.addClass('resizer-right');
        rzr.addClass('ui-resizable-handle');
        rzr.addClass('ui-resizable-e');
        nw.append( rzr ) ;
        
        var rzb = $('<div>');
        rzb.addClass('resizer');
        rzb.addClass('resizer-bottom');
        rzb.addClass('ui-resizable-handle');
        rzb.addClass('ui-resizable-s');
        nw.append( rzb ) ;
        
        var rzl = $('<div>');
        rzl.addClass('resizer');
        rzl.addClass('resizer-left');
        rzl.addClass('ui-resizable-handle');
        rzl.addClass('ui-resizable-w');
        nw.append( rzl ) ;
        
        
        var wIn = $('<div>');
        wIn.addClass('in');
        
                
        // title
        var wTt = $('<div>');
        wTt.addClass('title');
        wIn.append(wTt);
        
        // icon
        var wIc = $('<div>');
        wIc.addClass('icon') ;        
        wIn.append(wIc);
        
        nw.append( wIn ) ;
        
        
        $w = nw.appendTo( $('#b'+obj.board_id) );

        $w.resizable({
            containment: "parent",
            grid: [ 20, 20 ] ,
            handles: {
                'n':'.resizer-top',
                'e':'.resizer-right',
                's':'.resizer-bottom',
                'w':'.resizer-left'
            },
            minWidth: 40,
            minHeight:40,
            resize: function( event, ui ) {
                // gestion des contraintes - conflit avec un autre widget
            },
            stop: function( event , ui ) {
	            var wId = parseInt(ui.element.attr('id').split('w')[1], 10) ;
				var rq = {};
				rq['widget_id'] = wId ;
				var w = WIDGETS(rq).first();
                var nsR = '' + (parseInt(w.widget_sR,10) - ((ui.originalPosition.top - ui.position.top) / 20 )) ;
				var nsC = '' + (parseInt(w.widget_sC,10) - ((ui.originalPosition.left - ui.position.left) / 20 ));
                var neR = '' + (parseInt(w.widget_eR,10) - ((ui.originalSize.height - ui.size.height) / 20 ));
                var neC = '' + (parseInt(w.widget_eC,10) - ((ui.originalSize.width - ui.size.width) / 20 ));
                // Update local db
                var ww = WIDGETS(rq).update({widget_sR:nsR,widget_sC:nsC,widget_eR:neR,widget_eC:neC}).first();
                // send to server
				ww.action = 'savewidget';
                $.ajax({
					data : ww ,
					success : function( widgetdatas ) {
						// OK
					}
				});
            },
        });
        
        $w.draggable({
            containment: "parent",
            grid: [ 20, 20 ],
            handle:'.handler-move',

            drag: function( event , ui ) {
      
            },
            stop: function( event , ui ) {
                // gestion des contraintes - conflit avec un autre widget
                // si drop sur un autre widget > repositionnement initial

                
                // enregistrement des nouvelles coordonnées
                var wId = parseInt(ui.helper.attr('id').split('w')[1], 10) ;
                                
				var rq = {};
				rq['widget_id'] = wId ;
				var w = WIDGETS(rq).first();
				
                var nsR = '' + ( (ui.position.top / 20 ) + 1) ;
				var nsC = '' + ( (ui.position.left / 20 ) + 1) ;
                var neR = '' + ( parseInt(nsR,10) + (parseInt(w.widget_eR,10) - parseInt(w.widget_sR,10) ) );
                var neC = '' + ( parseInt(nsC,10) + (parseInt(w.widget_eC,10) - parseInt(w.widget_sC,10) ) );
                 
                 
                // Update local db
                var ww = WIDGETS(rq).update({widget_sR:nsR,widget_sC:nsC,widget_eR:neR,widget_eC:neC}).first();
                // send to server

				ww.action = 'savewidget';
				
                $.ajax({
					data : ww ,
					success : function( widgetdatas ) {
						// OK
					}
				});
                
            }
        });
    }



    
    
    // View
    // case update
    $w.removeClass('view-icon view-title view-both');
    // add view class
    $w.addClass( obj.widget_view );
    
    
    // Position icon/title
    $w.removeClass('left right above below');
    if ( obj.widget_view == 'view-both' ) {
        if ( obj.widget_view_both_position != '' ) {
            $w.addClass( obj.widget_view_both_position );
        }
    }


    // Set/Update title
    var tt = $w.find('.title');
    tt.html( obj.widget_title );
    var ttcolor = obj.widget_text_color || '000000';
    tt.css({color:'#'+ttcolor});
    // @TODO : couleur par défaut en fonction de la couleur de fond (brightness) du board


    // Set/Update icon
    var ic = $w.find('.icon');
    var iccolor = obj.widget_icon_color || '000000';
    ic.css({color:'#'+iccolor});
    // @TODO : couleur par défaut en fonction de la couleur de fond (brightness) du board
    ic.removeClass().addClass('icon').addClass(obj.widget_icon);


    // bgcolor
    var bgColor = obj.widget_background_color || 'ffffff';
    $w.css({backgroundColor:'#'+bgColor})
    // @TODO : couleur par défaut en fonction de la couleur de fond (brightness) du board
        // si le board à la class bright
    // @TODO : test brightness for class bright

    
}





function delete_widget( wid ) {
    
    var callback = (arguments.length) ? arguments[1] : false ;
    
    var datas = {
        action : 'deletewidget' ,
        pid : wid
    };
    
    
    $.ajax({
       data : datas ,
       success : function( msg ) {
            // remove from local db
            var rq = {};
            rq['widget_id'] = wid ;
            var w = WIDGETS(rq).remove() ;
            // remove from dom
            $('#w'+wid).addClass('deleted');
            setTimeout(function() {
                $('#w'+wid).remove();
            }, 300); 
       }
    });
    
    if ( callback ) {
        window[callback]();
    }
}


function edit_widget () {
    populate_widget_form();
}


function focus_widget() {
    if(  MODE == 'edit' ) {
        select_widget( $(this) );
    }else{
        
        var rq = {};
        rq['widget_id'] = parseInt( $(this).attr('id').split('w')[1], 10 ) ;
        var w = WIDGETS(rq).first();
        var wInfos = '';
        if ( w ) {
            if ( w.widget_title ) {
                wInfos = '<div class="title">'+w.widget_title+'</div>';
            }
            if ( w.widget_action ) {
                wInfos += '<div class="macro">Launch : <span>'+get_macro_name(w.widget_action)+'</span></div>';
            }
            if ( w.widget_note ) {
                wInfos += '<div class="note">'+w.widget_note+'</div>';
            }
        }
        $(this).tooltipster({
            theme:'tooltipster-kmr',
            debug:false,
            distance:2,
            contentAsHTML : true,
            content: wInfos ,
            functionAfter : function( instance , helper ) {
                instance.destroy();
            }
        }).tooltipster('open');
    }
}



function select_widget( $this ) {
    //deleteFromOccupiedGrid( parseInt($this.attr('data-sR'),10), parseInt($this.attr('data-sC'),10), parseInt($this.attr('data-eR'),10), parseInt($this.attr('data-eC'),10) );
    $this.parent().find('.selected').removeClass('selected');
    $this.addClass('selected');
}

function deselect_widget( ) {
    //populateOccupiedGrid( parseInt($this.attr('data-sR'),10), parseInt($this.attr('data-sC'),10), parseInt($this.attr('data-eR'),10), parseInt($this.attr('data-eC'),10) );
    $(this).removeClass('selected');
}




function do_widget_macro( ) {
    if( MODE == 'run' ) {
        var wid = parseInt($(this).attr('id').split('w')[1],10);
        var rq = {};
        rq['widget_id'] = wid ;
        var w = WIDGETS(rq).first();
        if ( w ) {
            if ( w.widget_action ) {
                var datas = {};
                datas.action = 'launchmacro';
                datas.macro = w.widget_action ;
                $.ajax({
                    data : datas , 
                    success : function( msg ) {
                        
                    }
                });
            }
        }
    }
}





