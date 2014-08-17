<?php
	checkAccess(3);
?>
<div class="titre_page">Saisie des bonus exceptionnels</div>
<div class="sectionPage">
	<form method="GET" action="index.php">
			Joueur: <select size=1 name="joueur">
				<option value=''> </option>
				<?php
				$listJoueursQuery = $db->getArray("select id,prenom,nom from joueur order by nom asc");
				foreach($listJoueursQuery as $joueur) {
					echo "<option value='{$joueur[0]}'>{$joueur[1]} {$joueur[2]}</option>";
				}
				?>
			</select>
			<input type="hidden" name="page" value="manageBonus"/>
			<input type="submit" value="Editer"/>
	</form>
</div>
<?php
	if (isset($_GET['joueur'])) {
		$joueur=$_GET['joueur'];
		$loadJoueurQuery = "select jo.prenom,jo.nom as nomJ,cl.nom as nomC from joueur as jo, club as cl where jo.id={$joueur} and jo.club_id=cl.id limit 1";
		$loadBonusQuery = "select bo.id,bo.type,bo.valeur from bonus_joueur as bo where bo.joueur_id={$joueur}";
		$storedJoueur = $db->getArray($loadJoueurQuery);
		$storedBonus = $db->getArray($loadBonusQuery);
		echo "<div class='sectionPage'>";
		echo "<div class='sous_titre'>{$storedJoueur[0]['prenom']} {$storedJoueur[0]['nomJ']} ({$storedJoueur[0]['nomC']})</div>";
		include('./div/editBonusDiv.php');
		echo "</div>";
		include('./div/addBonusDiv.php');
	}
	if (isset($_GET['ErrorMsg'])){
		$err =htmlspecialchars($_GET['ErrorMsg'], ENT_COMPAT, 'UTF-8');
		echo "<div class=\"error\">{$err}</div>";
	}
?>
		
