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
						min:0,
						max:50
					}
				);
				$handle.remove();
				$("<a href='#' class='slideUp_handle'><i class='fa fa-toggle-up'></i> Refermer</a>")
					.click(slideUpAction)
					.insertBefore($(this));
		});
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