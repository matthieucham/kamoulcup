// Variables globales utiles de la page.
var $serverSal;
var $serverTrans;
var $currentSal;
var $currentTrans;
var $currentCart;
// Places dispos dans l'effectif.
var $nbSpots={'G':0,'D':0,'M':0,'A':0};

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
			$currentSal -= $(value).data('json').salary.toFixed(1);
			var prize =$(value).find('.spinnerInput').spinner('value');
			console.log(prize);
			$currentTrans -= prize.toFixed(1);
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
	console.log('updateMarket');
	$.each($('#clubPlayersList .playerFree').not('.ui-draggable-dragging'),function(index,value) {
		$(value).removeClass('playerBlocked');
		if (($(value).data('json').salary > $currentSal) || ($(value).data('json').prize > $currentTrans)){
			$(value).draggable('disable');
		} else {
			console.log('Enable on '+$(value).data('json').name);
			$(value).draggable('enable');
		}
	});
	updateDisponibility();
}

// Input : tableau des effectifs actuels de la franchise.
function initSpots(initialStaff) {
	console.log("initSpots");
	for (i=0;i<initialStaff.length;i++) {
		if (initialStaff[i].affectedPlayer == null) {
			// Ce spot est libre
			$nbSpots[initialStaff[i].position] = $nbSpots[initialStaff[i].position]+1
		}
	}
	updateMarket();
}

function updateDisponibility() {
	console.log("updateDisponibility");
	// Disponibilité des joueurs pour le drag-drop:
	// - S'il reste une place pour leur poste
	// - S'il ne sont pas déjà dans le panier
	// 1) MAJ des nbSpots par poste en fonction de ce qu'il y a dans le panier.
	var currentSpots = {'G':$nbSpots['G'],'D':$nbSpots['D'],'M':$nbSpots['M'],'A':$nbSpots['A']};
	$.each($('#cartContent .playerFree').not('.ui-draggable-dragging'),function(index,value) {
		var currPlayerPosition = $(value).data('json').position;
		(currentSpots[currPlayerPosition])--;
		var currPlayerIdo = $(value).data('json').ido;
		$('#clubPlayersList #freePlayer'+currPlayerIdo).addClass('playerBlocked').draggable('disable');
	});
//	for (var poste in currentSpots) {
//		// Blocage de tous les joueurs qui ont un poste déjà occupé
//		if (currentSpots[poste] <= 0) {
//			$.each($('#clubPlayersList .playerFree').not('.ui-draggable-dragging'),function(index,value) {
//				if (poste == $(value).data('json').position) {
//					console.log('BLOCK '+poste);
//					$(value).addClass('playerBlocked').draggable('disable');
//				}
//			});
//		}
//	}
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
	
//	$.getJSON("../api/franchises.php", function( resp ) {
//		$serverSal = resp.salaryBudget;
//		$serverTrans = resp.transferBudget;
//		//$('#budgetInfo h2').text(resp.name);
//		$trs = (resp.transferBudget).toFixed(1)+' Ka';
//		$sal = (resp.salaryBudget).toFixed(1)+' Ka';
//		//$('#budgetInfo span.budgetValue:first').text($trs);
//		//$('#budgetInfo span.budgetValue:last').text($sal);
//		$effectif = resp.effectif;
//		$effectifPlaceholder = $('#budgetInfo div.contract_positions_container');
//		for ($i=0;$i<$effectif.length; $i++) {
//			$position = jQuery("<div>", {
//				class:"contract_position",
//				text:$effectif[$i].position
//				});
//			if ($effectif[$i].affectedPlayer == null) {
//				$('<div class="pos_marker pos_marker_empty" />').appendTo($position);
//			} else {
//				$('<div class="pos_marker pos_marker_filled">').attr("title",$effectif[$i].affectedPlayer).appendTo($position);
//			}
//			$position.appendTo($effectifPlaceholder);
//		}
//		initSpots(resp.effectif);
//		updateBudget();
//	});
	
	
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
				
				var $addedLi = $('<div>').text(ui.draggable.data('json').name).data('json',ui.draggable.data('json')).addClass('playerFree');
				jQuery("<span/>",{
					class: "playerPosition",
					text:ui.draggable.data('json').position,
					title:"Attaquant"
				}).appendTo($addedLi);
				jQuery("<span/>",{
					class: "playerSalary",
					text:ui.draggable.data('json').salary+' Ka',
					title:"Salaire courant"
				}).appendTo($addedLi);
				$addedLi.append(
					'<input type="hidden" name="selectedPlayerId[]" value=">'+ui.draggable.data('json').ido+'"/>'+
					'<input class="spinnerInput" name="amountForIdo'+ui.draggable.data('json').ido+'" value="'+ui.draggable.data('json').prize+'" size="3" maxlength="4" id="amountForIdo'+ui.draggable.data('json').ido+'"/>'
				);
				
				$addedLi.prepend($('<a>').addClass('removeCartBtn').text('X').data('ido',ui.draggable.data('json').ido).attr('href','#').click(function() {
							$('#playerCart'+$(this).data('ido')).remove();
							initCart();
							updateBudget();
							updateMarket();
							//updateDisponibility();
						}));
				
				$li = $('<li>').attr('id','playerCart'+ui.draggable.data('json').ido).append($addedLi);
				
				$( this ).find("ul").append($li);
					
				$('#amountForIdo'+ui.draggable.data('json').ido).spinner({
					step:0.1,
					numberFormat:'n',
					min:ui.draggable.data('json').prize,
					max:$serverTrans,
					stop: updateDynamicBudget,
					change:updateMarketAndBudget,
					create: function(event,ui) {
							initCart();
							updateMarketAndBudget();
						}
					});
				/*initCart();
				updateBudget();
				updateMarket();*/
				//updateDisponibility();
			}
		});
		$("sendCartBtn").bind('budgetChanged',function() {
			if ($currentTrans < 0) {
				$(this).attr('disabled', 'disabled');
			} else {
				$(this).removeAttr('disabled');
			}
		});
});