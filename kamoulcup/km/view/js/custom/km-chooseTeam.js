$( document ).ready(function() {
    $("#registerBtn").click(function(event) {
        $("form#compoForm").submit();
    });
    
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
    
    $("form#compoForm").submit(function(event) {
        event.preventDefault();
        // AJAX post du formulaire
        $("#registerPopup").removeClass("hide").addClass("show");
        
        // TODO sauver les remplaçants !
        console.log("hello");
        $.post("../ctrl/saveCompo.php",$("form#compoForm").serialize(),function( data ) {
                $("#registerPopup").removeClass("show").addClass("hide");
                    if (data.success === true) {
                        $("#registerResult .uppings").removeClass("hide").addClass("show");
                        $("#registerResult .downings").removeClass("show").addClass("hide");
                    } else {
                        $("#registerResult .uppings").removeClass("show").addClass("hide");
                        $("#registerResult .downings").removeClass("hide").addClass("show").text('ERREUR ! '+data.message);
                    }
                },'json'
            ).error(
               function( data ) {
                $("#registerPopup").removeClass("show").addClass("hide");
                    $("#registerResult .uppings").removeClass("show").addClass("hide");
                    $("#registerResult .downings").removeClass("hide").addClass("show").text('Impossible d\'enregistrer la composition');
                }
            );
    });
});

