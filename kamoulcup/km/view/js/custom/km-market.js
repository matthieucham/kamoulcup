// Variables globales utiles de la page.
var $masseSalarialeMax;
var $serverSal;
var $serverTrans;
var $currentSal;
var $currentTrans;
var $currentCart;
var $currentSpots={'G':0,'D':0,'M':0,'A':0};
var $currentNbPlayers;
// Places dispos dans l'effectif.
var $nbSpotsMin={'G':0,'D':0,'M':0,'A':0};
var $nbMaxJoueurs;

function initCart() {
	$currentCart = $('#cartContent .playerFree');
}
	
function updateBudget() {
	console.log("updateBudget !");
	if ($currentCart == null)
	{
		initCart();
	}
	$currentSal = $serverSal;
	$currentTrans = $serverTrans;
	$.each($currentCart, function (index,value) {
		$currentSal += $(value).data('json').salary;
		var prize =$(value).find('.spinnerInput').spinner('value');
		$currentTrans -= prize;
	});
	$('#cartValue span:first').text($currentSal.toFixed(1));
	$('#cartValue span:last').text($currentTrans.toFixed(1));
	$('#sendCartBtn').trigger('budgetChanged');
}

function updateDynamicBudget(event,ui) {
	updateBudget();
}

function updateMarketAndBudget(event,ui) {
	updateBudget();
	updateMarket();
}

function updateMarket(){
	$.each($('#clubPlayersList .playerFree').not('.ui-draggable-dragging'),function(index,value) {
		$(value).removeClass('playerBlocked');
		if (($(value).data('json').prize > $currentTrans)){
			$(value).draggable('disable');
		} else {
			$(value).draggable('enable');
		}
	});
	updateDisponibility();
}

function updateDisponibility() {
	// Disponibilité des joueurs pour le drag-drop:
	// - S'il reste une place
	// - S'il ne sont pas déjà dans le panier
	// 1) MAJ des nbSpots par poste en fonction de ce qu'il y a dans le panier.
	$currentSpots = {'G':$nbSpotsMin['G'],'D':$nbSpotsMin['D'],'M':$nbSpotsMin['M'],'A':$nbSpotsMin['A']};
    $currentNbPlayers = 0;
	$.each($('#cartContent .playerFree').not('.ui-draggable-dragging'),function(index,value) {
		var currPlayerPosition = $(value).data('json').position;
		($currentSpots[currPlayerPosition])--;
        $currentNbPlayers++;
		var currPlayerIdo = $(value).data('json').ido;
		$('#clubPlayersList #freePlayer'+currPlayerIdo).addClass('playerBlocked').draggable('disable');
	});
    if ($currentNbPlayers >= $nbMaxJoueurs) {
        // Blocage de tous les joueurs
        $.each($('#clubPlayersList .playerFree').not('.ui-draggable-dragging'),function(index,value) {
			$(value).addClass('playerBlocked').draggable('disable');
        });
    }
    $('#sendCartBtn').trigger('budgetChanged');
}

function addToCart(jsonData) {
    var $addedLi = $('<div>').text(jsonData.name).data('json',jsonData).addClass('playerFree');
    jQuery("<span/>",{
					class: "playerPosition",
					text:jsonData.position
				}).appendTo($addedLi);
    jQuery("<span/>",{
					class: "playerSalary",
					text:jsonData.salary+' Ka',
					title:"Salaire courant"
				}).appendTo($addedLi);
    $addedLi.append(
					'<input class="spinnerInput" name="amountForPlayer['+jsonData.ido+']" value="'+Math.max(0.1,jsonData.prize,jsonData.offer).toFixed(1)+'" size="3" maxlength="4" id="amountForIdo'+jsonData.ido+'"/>'
				);
    $addedLi.prepend($('<a>').addClass('removeCartBtn').text('X').data('ido',jsonData.ido).attr('href','#').click(function() {
							$('#playerCart'+$(this).data('ido')).remove();
							initCart();
							updateBudget();
							updateMarket();
							//updateDisponibility();
						}));
    $li = $('<li>').attr('id','playerCart'+jsonData.ido).append($addedLi);
    $( '#cartContent ul' ).append($li);
				
    $('#amountForIdo'+jsonData.ido).spinner({
					step:0.1,
					numberFormat:'n',
					min:Math.max(jsonData.prize,0.1),
					max:$serverTrans,
					stop: updateDynamicBudget,
					change:updateMarketAndBudget,
					create: function(event,ui) {
							initCart();
							updateMarketAndBudget();
						}
    });
    
    
}



$( document ).ready(function() {
	var $clubSelect = $('#clubSelect');
	var $jsonData;
	$.getJSON("../api/clubs.php", function( resp ) {
		$.each(resp, function (index,value) {
			$clubSelect.append($('<option>').text(value.name).attr('value',index));
		});
		$jsonData = resp;
		loadClub(0);
	});
    
    $serverSal=parseFloat($('#initSalaryValue').val());
    $serverTrans=parseFloat($('#initBudgetValue').val());
    $masseSalarialeMax=parseFloat($('#maxSalary').val());
    $nG = parseInt($('#nbMinG').val());
    $nD = parseInt($('#nbMinD').val());
    $nM = parseInt($('#nbMinM').val());
    $nA = parseInt($('#nbMinA').val());
    $nbSpotsMin={'G':$nG,'D':$nD,'M':$nM,'A':$nA};
    $nbMaxJoueurs = parseInt($('#maxPlayers').val());

    
    $.getJSON("../api/offres.php", function( resp ) {
        // Itérer sur toutes les offres enregistrées pour initialiser le panier.
        for ($i=0;$i<resp.length; $i++) {
            addToCart(resp[$i]);
        }
    });
    
    
	$clubSelect.on('change', function() {
		loadClub(this.value);
		updateMarket();
	});

	function loadClub(idx) {
		console.log('loadClub '+idx);
		$('#selectedClubName').text(($jsonData[idx]).name);
		$('#playersList_list').empty();
		loadPlayers(idx);
		updateDisponibility();
	}

	function loadPlayers(idx) {
		var $players = $jsonData[idx].players;
		$.each($players,function (index,value) {
			var $addedLi = $('<li>').attr('id','freePlayer'+value.ido).text(value.name).data('json',value).appendTo('#playersList_list');
			if (value.prize < 0) {
				$addedLi.addClass('playerNotForSale');
			}
			else {
				$addedLi.addClass('playerFree');
			}
			
			jQuery("<span/>",{
				class: "playerPosition",
				text:value.position,
				title:"Attaquant"
			}).appendTo($addedLi);
			
			jQuery("<span/>",{
				class: "playerSalary",
				text:value.salary+' Ka',
				title:"Salaire courant"
			}).appendTo($addedLi);
			
			if (value.prize > 0) {
				jQuery("<span/>",{
				class: "playerPrize",
				text:value.prize+' Ka',
				title:"Vendu par Nation of Domination"
			}).appendTo($addedLi);
			}
		});
		$(".playerFree").draggable({ scroll:true, revert: 'invalid', helper: "clone" });
		$( ".playerPosition" ).disableSelection();
	};
    
	
	$( "#cartContent" ).droppable({
			hoverClass: "dropTarget",
			accept: ".playerFree",
			drop: function( event, ui ) {
				$( this ).find( ".placeholder" ).remove();
				
                addToCart(ui.draggable.data('json'));
			}
		});
	$("#sendCartBtn").bind('budgetChanged',function() {
            // 1) Check budget
			if ($currentTrans < 0) {
				$(this).attr('disabled', 'disabled');
			} else if ($masseSalarialeMax-$currentSal < 0) {
                $(this).attr('disabled', 'disabled');
            } else {
                // Check players in cart
                if ($currentNbPlayers >= $nbMaxJoueurs) {
                    $(this).attr('disabled', 'disabled');
                } else {
                    $disable = false;
                    $disable = ($currentSpots['G'] > 0 || $currentSpots['D'] > 0 || $currentSpots['M'] > 0 || $currentSpots['A'] > 0)
                    if ($disable) {
                        $(this).attr('disabled', 'disabled');
                    } else {
                        $(this).removeAttr('disabled');
                    }
                }
			}
		});
    
    $("form#cartForm").submit(function(event) {
        console.log($("form#cartForm").serialize());
    });
    
    updateBudget();
    updateMarket();
});