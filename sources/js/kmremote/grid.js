function makeGrid( board ) {
    
    // une seul grille active à la fois pour des question de performance
    // @TODO : sélectionner uniquement le board active > cf var global
    $('.board').find('.grid').html('');
    
    var screenW = $(window).width();
    var screenH = $(window).height();
    
    var availableW = screenW - 24;
    var availableH = screenH - 28;
    
    var nGridItemW = Math.ceil( availableW / 20 ) ;
    var nGridItemH = Math.ceil( availableH / 20 ) ;
    
    var h = 1 ;
    
    var container = $('<div>');
    
    while( h <= nItemH ) {
        var w = 1 ;
        while( w <= nItemW ) {
            var gitem = $('<div>') ;
            gitem.addClass('grid-unit');
            gitem.attr('data-row' , h);
            gitem.attr('data-col',w);
            if ( h < 3 && w >= nItemW-1 ) {
                gitem.addClass('hidden');
            }
            container.append( gitem ) ;
            w++;
        }
        h++;
    }
    
    board.find('.grid').html( container.html() );
}




(function($){
    
    var startUnitCol = '';
    var startUnitRow = ''; 
    
    var endUnitCol = '';
    var endUnitRow = '';
    
    var selection = false;
    
    // début de sélection
    $('#boards').on('mousedown touchstart','.grid-unit', function(e){
        startUnitCol = parseInt($(this).attr('data-col'),10);
        startUnitRow = parseInt($(this).attr('data-row'),10);
        selection = true;
    });
    
    // sélection
    $('#boards').on('mouseenter touchmove', '.grid-unit' , function(e){
        e.preventDefault();
        var elem = document.elementFromPoint(e.pageX, e.pageY);
        if ( selection ) {
            endUnitCol = parseInt($(elem).attr('data-col'),10);
            endUnitRow = parseInt($(elem).attr('data-row'),10);
            selectUnit();
        }
        return false;
    });
    
    //changement d'état
    function selectUnit () {
        $('.grid-unit.on').removeClass('on');
        $('.grid-unit').filter(function(index){
            var c = parseInt($(this).attr('data-col'),10) ;
            var r = parseInt($(this).attr('data-row'),10) ;
            return ( c >= startUnitCol && c <= endUnitCol && r >= startUnitRow && r <= endUnitRow) || false ;
        }).addClass('on');
    }
    
    
    // fin de sélection > sélectionné
    $('#boards').on('mouseup touchend', function(){
        selection = false;
        if ( $('.grid-unit.on').length > 3 ) {
            init_new_widget( startUnitCol , startUnitRow , endUnitCol , endUnitRow );
        }else{
            $('.grid-unit.on').removeClass( 'on' );
        }
    });
    
})(jQuery);