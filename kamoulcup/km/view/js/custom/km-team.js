function slideUpAction() {
	$handle = $(this);
		$( this ).next('div.transferList_actions').slideUp(function() {
				$handle.remove();
				$("<a href='#' class='transferList_handle'></a>")
					.text(" Actions")
					.prepend("<i class='fa fa-toggle-down'></i>")
					.click(slideDownAction)
					.insertBefore($(this));
		});
}

function slideDownAction() {
	$handle = $(this);
	$( this ).next('div.transferList_actions').slideDown(function() {
				$(this).find('input.sellPrice_input').spinner(
					{
						step:0.1,
						numberFormat:'n',
						min:0.1,
						max:50
					}
				);
				$handle.remove();
				$("<a href='#' class='slideUp_handle'><i class='fa fa-toggle-up'></i> Refermer</a>")
					.click(slideUpAction)
					.insertBefore($(this));
		});
    $("form[action='../ctrl/firePlayer.php'] button").click(function(event) {
        event.preventDefault();
     openConfirmDialog('fire',$(this).parent().find("input[name='playerid']").val(),$(this).parent().find("input[name='playername']").val(),0);
            });
    $("form[action='../ctrl/listPlayer.php'] button").click(function(event) {
        event.preventDefault();
     openConfirmDialog('list',$(this).parent().find("input[name='playerid']").val(),$(this).parent().find("input[name='playername']").val(),$(this).parent().find("input.sellPrice_input").val());
            });
    $("form[action='../ctrl/unlistPlayer.php'] button").click(function(event) {
        event.preventDefault();
        openConfirmDialog('unlist',$(this).parent().find("input[name='playerid']").val(),$(this).parent().find("input[name='playername']").val(),0);
            });
}

function openConfirmDialog(typeDialog,playerId,playerName,amount) {
    if (typeDialog == 'fire') {
        $("#dialog-confirm").html("Libérer le joueur "+playerName+" pour 0 Ka ?");    
    } else if (typeDialog == 'list') {
        $("#dialog-confirm").html("Placer le joueur "+playerName+" sur la liste des transferts pour "+amount+" Ka ?");
    } else if (typeDialog == 'unlist') {
        $("#dialog-confirm").html("Retirer le joueur "+playerName+" de la liste des transferts ?");
    }
    // Define the Dialog and its properties.
    $("#dialog-confirm").dialog({
        resizable: false,
        modal: true,
        title: "Lisezceci",
        height: 250,
        width: 400,
        buttons: {
            "Oui": function () {
                $(this).dialog('close');
                confirmCallback(true,typeDialog,playerId);
            },
            "Non": function () {
                $(this).dialog('close');
                confirmCallback(false,typeDialog,playerId);
            }
        }
    });
}

function confirmCallback(yesNo,type,playerId) {
    if (yesNo) {
        $("#form-"+type+"-"+playerId).submit();
    }
}

$( document ).ready(function() {
	$('#teamPlayerInfo_action .sellPrice_input').spinner(
		{
			step:0.1,
			numberFormat:'n',
			min:0,
			max:50
		}
	);
	
	$( ".transferList_handle" ).click(slideDownAction);
	$( ".slideUp_handle" ).click(slideUpAction);
});