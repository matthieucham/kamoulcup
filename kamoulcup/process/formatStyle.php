<?php

function getURLPhotoJoueur($equipeId){
	//return 'http://www.lequipe.fr/Football/photos/FootballImage'.$equipeId.'.jpg';
	return 'http://medias.lequipe.fr/img-sportif-foot/'.$equipeId.'/100';
}

function getURLLogoClub($equipeId) {
	return 'http://medias.lequipe.fr/logo-football/'.$equipeId.'/150?c';
}

function getURLLogoClubSmall($equipeId) {
	return 'http://medias.lequipe.fr/logo-football/'.$equipeId.'/30';
}

function getURLFicheJoueur($equipeId) {
	return 'http://www.lequipe.fr/Football/FootballFicheJoueur'.$equipeId.'.html';
}
?>