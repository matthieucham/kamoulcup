<?php
	function traduire($cle) {
		if ($cle == 'G') {
			return "Gardien";
		}
		if ($cle == 'D') {
			return "Défenseur";
		}
		if ($cle == 'M') {
			return "Milieu";
		}
		if ($cle == 'A') {
			return "Attaquant";
		}
		if ($cle == 'PA') {
			return "Proposition d'achat";
		}
		if ($cle == 'MV') {
			return "Mise en vente";
		}
		if ($cle == 'RE') {
			return "Revente à la banque";
		}
		if ($cle == 'TR') {
			return "Transfert";
		}
		if ($cle == 'VE') {
			return "Vente";
		}
		if ($cle == 'AC') {
			return "Achat";
		}
		if ($cle == 'NO') {
			return "Notation";
		} 
		if ($cle == 'UNFP_ET') {
			return "Equipe type de la saison";
		} 
		if ($cle == 'UNFP_BY') {
			return "Meilleur espoir de la saison";
		} 
		if ($cle == 'UNFP_BP') {
			return "Meilleur joueur de la saison";
		} 
		if ($cle == 'UNFP_BK') {
			return "Meilleur gardien de la saison";
		} 
	}
	
	function infotexte($cle, $id, $prenom, $nom, $club, $prix) {
		if ($cle == 'TR') {
			return "<a href='index.php?page=detailJoueur&joueurid={$id}'>{$prenom} {$nom}</a> a rejoint {$club}";
		}
		if ($cle == 'VE') {
			return "Vous avez vendu <a href='index.php?page=detailJoueur&joueurid={$id}'>{$prenom} {$nom}</a> pour {$prix} Ka";
		}
		if ($cle == 'AC') {
			return "Vous avez acheté <a href='index.php?page=detailJoueur&joueurid={$id}'>{$prenom} {$nom}</a> pour {$prix} Ka";
		}
		if ($cle == 'NO') {
			return "La note de votre joueur <a href='index.php?page=detailJoueur&joueurid={$id}'>{$prenom} {$nom}</a> a évolué";
		}
		if ($cle == 'SE') {
			return "Vous avez sélectionné <a href='index.php?page=detailJoueur&joueurid={$id}'>{$prenom} {$nom}</a> pour la phase suivante";
		}
	}
	
	function picto($cle) {
		if ($cle == 'TR') {
			return "images/sport_soccer.png";
		}
		if ($cle == 'VE') {
			return "images/money_dollar.png";
		}
		if ($cle == 'AC') {
			return "images/trophy.png";
		}
		if ($cle == 'NO') {
			return "images/chart_curve.png";
		}
		if ($cle == 'SE') {
			return "images/target.png";
		}
		if ($cle == 'BU') {
			return "images/trophy.png";
		}
		if ($cle == 'PD') {
			return "images/telephone.png";
		}
		if ($cle == 'PE') {
			return "images/trophy_silver.png";
		}
		if ($cle == 'PO') {
			return "images/bandaid.png";
		}
		if ($cle == 'BD') {
			return "images/wall_brick.png";
		}
		if ($cle == 'BP') {
			return "images/wall.png";
		}
		if ($cle == 'BE') {
			return "images/star_1.png";
		}
		if ($cle == 'BJ') {
			return "images/wall_break.png";
		}
		if ($cle == '3B') {
			return "images/medal_gold_1.png";
		}
		if ($cle == '3BP') {
			return "images/medal_bronze_1.png";
		}
	}
?>