$( document ).ready(function() {
    
    $("#compoBench .benchPlayer").draggable({ scroll:true, revert: 'invalid', helper: "clone" });
    
    $( "#compo .compoPlayer[position='posG']" ).droppable({
        hoverClass:"compoPlayerDrop",
        accept:"#benchG .benchPlayer",
        drop: dropCompoPlayer
    });
    
    $( "#compo .compoPlayer[position='posD']" ).droppable({
        hoverClass:"compoPlayerDrop",
        accept:"#benchD .benchPlayer",
        drop: dropCompoPlayer
        }
    );
    
    $( "#compo .compoPlayer[position='posM']" ).droppable({
        hoverClass:"compoPlayerDrop",
        accept:"#benchM .benchPlayer",
        drop: dropCompoPlayer
    });
    
    $( "#compo .compoPlayer[position='posA']" ).droppable({
        hoverClass:"compoPlayerDrop",
        accept:"#benchA .benchPlayer",
        drop: dropCompoPlayer
    });
    
    function dropCompoPlayer( event, ui ) {

        var oldVal= $(this).find('input[type="hidden"]').val();
        $('#compoBench').find('#bp_'+oldVal).removeClass('hide');
        var newVal= ui.draggable.find('input[type="hidden"]').val();
        $(this).find('input[type="hidden"]').val(newVal);
        $( this ).find('p').remove();
        $(this).append('<p>'+ui.draggable.text()+'</p>');
        
        $('#compoBench').find('#bp_'+newVal).addClass('hide');
    }
    
});

