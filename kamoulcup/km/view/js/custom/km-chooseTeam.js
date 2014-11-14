$( document ).ready(function() {
    
    // Initialiser la valeur 'sub=0' sur tous les joueurs qui sont déjà titulaires:
    // $('#compoBench').find('#bp_'+newVal).addClass('hide').find('input[name*="sub"]').val(0);
    
    /*$(".compoPlayer").each(function() {
        var titulaireId= $(this).find('input[type="hidden"]').val();
        $('#compoBench').find('#bp_'+titulaireId).find('input[name*="sub"]').val(0);
    });*/
    
    function removePlayerHandler() {
        var oldVal= $(this).parent().find('input[type="hidden"]').val();
        $('#compoBench').find('#bp_'+oldVal).removeClass('hide');
        $(this).parent().find('input[type="hidden"]').val('');
        $(this).parent().find('p').remove();
        $(this).parent().find('.actionCompoPlayer').remove();
    }
    
    function addPlayerHandler(){
        // Trouver le spot libre s'il existe
        var targetPos = $(this).parent().attr('position');
        var targetDiv = $('#compo').find('.compoPlayer[position="'+targetPos+'"] input[value=""]:first').parent();
        if (targetDiv.length) {
            // Mettre à jour le contenu du spot avec les données de $(this)
            addCompoPlayer(targetDiv,$(this).parent());
        }
        // 
        var btnDiv = $('<div>').addClass('actionCompoPlayer').html("<i class='fa fa-minus-square'></i>").click(removePlayerHandler);
    }

    $(".compoPlayer .actionCompoPlayer").click(removePlayerHandler);
    
    $(".benchPlayer .actionCompoPlayer").click(addPlayerHandler);
    
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
        $(this).find('p').remove();
        $(this).find('.actionCompoPlayer').remove();
        
        /*var newVal= ui.draggable.find('input[type="hidden"]').val();
        $(this).find('input[type="hidden"]').val(newVal);
        var btnDiv = $('<div>').addClass('actionCompoPlayer').html("<i class='fa fa-minus-square'></i>").click(removePlayerHandler);
        $(this).append(btnDiv);
        $(this).append('<p>'+ui.draggable.text()+'</p>');
        
        $('#compoBench').find('#bp_'+newVal).addClass('hide').find('input[name*="sub"]').val(0);*/
        addCompoPlayer($(this),ui.draggable);
    }
    
    function addCompoPlayer(targetDiv,benchPlayer) {
        var newVal= benchPlayer.find('input[type="hidden"]').val();
        targetDiv.find('input[type="hidden"]').val(newVal);
        var btnDiv = $('<div>').addClass('actionCompoPlayer').html("<i class='fa fa-minus-square'></i>").click(removePlayerHandler);
        targetDiv.append(btnDiv);
        targetDiv.append('<p>'+benchPlayer.text()+'</p>');
        
        $('#compoBench').find('#bp_'+newVal).addClass('hide').find('input[name*="sub"]').val(0);
    }
    
    $("form#compoForm").submit(function(event) {
        event.preventDefault();
        // AJAX post du formulaire
        $("#registerPopup").removeClass("hide").addClass("show");

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

