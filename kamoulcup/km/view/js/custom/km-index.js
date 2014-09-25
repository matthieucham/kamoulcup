function loadContent(pageName){
	// Using the core $.ajax() method
	$.ajax({
		// the URL for the request
		url: pageName+'.php',
		// the data to send (will be converted to a query string)
		data: {
			id: 123,
			page: 'tousLesMatchs'
			
		},
		// whether this is a POST or GET request
		type: 'GET',
		// the type of data we expect back
		dataType : 'html',
		// code to run if the request succeeds;
		// the response is passed to the function
		success: function( content ) {
			$('#main').find('#main-content').remove();
			$( "<div/>" ).attr('id','main-content').append( content ).appendTo( '#main' );
			// changer le focus sur le menu
			$('nav.menu a').removeClass('current');
			$('#menu-target-'+pageName).addClass('current');
		},
		// code to run if the request fails; the raw request and
		// status codes are passed to the function
		error: function( xhr, status, errorThrown ) {
			console.log( "Error: " + errorThrown );
			console.log( "Status: " + status );
			console.dir( xhr );
		}
	});
}

$(function(){

	/*********************************/
	/*       Affectation du menu     */
	/*********************************/
	$('#menu-target-home').click(function() {loadContent('home')});
	$('#menu-target-team').click(function() {loadContent('team')});
	$('#menu-target-fixtures').click(function() {loadContent('fixtures')});
	$('#menu-target-market').click(function() {loadContent('market')});
	$('#menu-target-user').click(function() {loadContent('user')});

	
	
	/*********************************/
	/*    Initialisation du menu     */
	/*********************************/
	loadContent('home');
});