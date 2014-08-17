<?php
	$loadClubsQuery = $db->getArray("select club_dom_id, club_ext_id,journee_id from rencontre where rencontre.id={$_GET['matchId']}");
	$loadJoueursDomQuery = $db->getArray("select jo.id,jo.nom,jo.prenom from joueur as jo, rencontre as re where (jo.club_id = re.club_dom_id) and (re.id='{$_GET['matchId']}') order by jo.nom asc");
	$loadJoueursExtQuery = $db->getArray("select jo.id,jo.nom,jo.prenom from joueur as jo, rencontre as re where (jo.club_id = re.club_ext_id) and (re.id='{$_GET['matchId']}') order by jo.nom asc");
	$storedPrestationsDomQuery = $db->getArray("select pr.id,pr.joueur_id,pr.note_lequipe,pr.note_ff,pr.note_sp,pr.note_d,pr.note_e,pr.penalty_obtenu,pr.minutes,pr.arrets,pr.encaisses from prestation as pr where pr.club_id='{$loadClubsQuery[0]['club_dom_id']}' and pr.match_id='{$_GET['matchId']}'");
	$storedPrestationsExtQuery = $db->getArray("select pr.id,pr.joueur_id,pr.note_lequipe,pr.note_ff,pr.note_sp,pr.note_d,pr.note_e,pr.penalty_obtenu,pr.minutes,pr.arrets,pr.encaisses from prestation as pr where pr.club_id='{$loadClubsQuery[0]['club_ext_id']}' and pr.match_id='{$_GET['matchId']}'");
	$storedButsDomQuery = $db->getArray("select bu.id,bu.buteur_id,bu.passeur_id,bu.penalty,bu.prolongation from buteurs as bu where bu.dom_ext='DOM' and bu.rencontre_id={$_GET['matchId']}");
	$storedButsExtQuery = $db->getArray("select bu.id,bu.buteur_id,bu.passeur_id,bu.penalty,bu.prolongation from buteurs as bu where bu.dom_ext='EXT' and bu.rencontre_id={$_GET['matchId']}");
?>
<form method="POST" action="process/savePrestations.php">
	<div class='sectionPage'>
		<div class="sous_titre">Buts</div>
		<?php
			$butsDom = $getMatchQuery[0][4];
			$butsExt = $getMatchQuery[0][5];
			echo "<input type=\"hidden\" name=\"nbButsDom\" value=\"{$butsDom}\"/>";
			echo "<input type=\"hidden\" name=\"nbButsExt\" value=\"{$butsExt}\"/>";
			
			// BUTS MARQUES PAR L'EQUIPE A DOMICILE
			$idButDom = array();
			$nouveauButDom = array();
			$buteurButDom = array();
			$passeurButDom = array();
			$penaltyButDom = array();
			$prolongationButDom = array();
			
			echo "<p>Buts pour {$getMatchQuery[0][0]}</p>";
			for ($i=0;$i<$butsDom;$i++)
			{
				$currBut = Array('id' => '', 'buteur_id' => '', 'passeur_id' => '', 'penalty' => '0', 'prolongation' => '0');
				$nouveau = 1;
				if (isset($storedButsDomQuery[$i])){
					$currBut = $storedButsDomQuery[$i];
					$nouveau = 0;
				}
				echo '<p>'.($i+1).' ';
				echo "<input type=\"hidden\" name=\"nouveauButDom[{$i}]\" value=\"{$nouveau}\"/><input type=\"hidden\" name=\"idButDom[{$i}]\" value=\"{$currBut['id']}\"/>";
				echo "Buteur: ";
				echo "<select size=\"1\" name=\"buteurButDom[{$i}]\" >";
				echo "<option value=\"0\">C.S.C.</option>";
				if ($loadJoueursDomQuery != NULL) {
					foreach($loadJoueursDomQuery as $joueurDom) {
						$selected = ($currBut['buteur_id'] == $joueurDom[0]);
						echo "<option value=\"{$joueurDom[0]}\" ";
						if ($selected) {
								echo "selected ";
							}
						echo ">{$joueurDom[2]} {$joueurDom[1]}</option>";
					}
				}
				echo "</select>";
				echo " Passeur: ";
				echo "<select size=\"1\" name=\"passeurButDom[{$i}]\" >";
				echo "<option value=\"\"> </option>";
				if ($loadJoueursDomQuery != NULL) {
					foreach($loadJoueursDomQuery as $joueurDom) {
						$selected = ($currBut['passeur_id'] == $joueurDom[0]);
						echo "<option value=\"{$joueurDom[0]}\" ";
						if ($selected) {
								echo "selected ";
							}
						echo ">{$joueurDom[2]} {$joueurDom[1]}</option>";
					}
				}
				echo "</select>";
				echo " Penalty ? ";
				echo "<input type=\"checkbox\" name=\"penaltyButDom[{$i}]\" value=\"{$currBut['penalty']}\"";
				if ($currBut['penalty'] == 1) {
					echo " checked";
				}
				echo"/>";
				echo " En prolongations ? ";
				echo "<input type=\"checkbox\" name=\"prolongationButDom[{$i}]\" value=\"{$currBut['prolongation']}\"";
				if ($currBut['prolongation'] == 1) {
					echo " checked";
				}
				echo"/>";
				echo "</p>";
			}
			
			// BUTS MARQUES PAR L'EQUIPE A L'EXTERIEUR
			$idButExt = array();
			$nouveauButExt = array();
			$buteurButExt = array();
			$passeurButExt = array();
			$penaltyButExt = array();
			$prolongationButExt = array();
		
			echo "<p>Buts pour {$getMatchQuery[0][2]}</p>";
			for ($i=0;$i<$butsExt;$i++)
			{
				$currBut = Array('id' => '', 'buteur_id' => '', 'passeur_id' => '', 'penalty' => '0', 'prolongation' => '0');
				$nouveau = 1;
				if (isset($storedButsExtQuery[$i])){
					$currBut = $storedButsExtQuery[$i];
					$nouveau = 0;
				}
				echo '<p>'.($i+1).' ';
				echo "<input type=\"hidden\" name=\"nouveauButExt[{$i}]\" value=\"{$nouveau}\"/><input type=\"hidden\" name=\"idButExt[{$i}]\" value=\"{$currBut['id']}\"/>";
				echo "Buteur: ";
				echo "<select size=\"1\" name=\"buteurButExt[{$i}]\" >";
				echo "<option value=\"0\">C.S.C.</option>";
				if ($loadJoueursExtQuery != NULL) {
					foreach($loadJoueursExtQuery as $joueurExt) {
						$selected = ($currBut['buteur_id'] == $joueurExt[0]);
						echo "<option value=\"{$joueurExt[0]}\" ";
						if ($selected) {
								echo "selected ";
							}
						echo ">{$joueurExt[2]} {$joueurExt[1]}</option>";
					}
				}
				echo "</select>";
				echo " Passeur: ";
				echo "<select size=\"1\" name=\"passeurButExt[{$i}]\" >";
				echo "<option value=\"\"> </option>";
				if ($loadJoueursExtQuery != NULL) {
					foreach($loadJoueursExtQuery as $joueurExt) {
						$selected = ($currBut['passeur_id'] == $joueurExt[0]);
						echo "<option value=\"{$joueurExt[0]}\" ";
						if ($selected) {
								echo "selected ";
							}
						echo ">{$joueurExt[2]} {$joueurExt[1]}</option>";
					}
				}
				echo "</select>";
				echo " Penalty ? ";
				echo "<input type=\"checkbox\" name=\"penaltyButExt[{$i}]\" value=\"{$currBut['penalty']}\"";
				if ($currBut['penalty'] == 1) {
					echo " checked";
				}
				echo "/>";
				echo " En prolongations ? ";
				echo "<input type=\"checkbox\" name=\"prolongationButExt[{$i}]\" value=\"{$currBut['prolongation']}\"";
				if ($currBut['prolongation'] == 1) {
					echo " checked";
				}
				echo "/>";
				echo "</p>";
			}
		?>
	</div>

	<div class='sectionPage'>
		<div class="sous_titre">Notes</div>
		<p><b>Domicile:</b></p>
		<table class="tableau_liste_centre">
			<tr>
				<th></th><th>Joueur</th><th>Tps de jeu</th><th>L'Eq.</th><th>WhoSc.</th><th>-</th><th></th><th>-</th><th>Peno obtenu<br/>non marqué</th><th>Arrêts</th><th>Encaissés</th>
			</tr>		
			<?php
				// 14 joueurs par équipe max
				$idDom = array();
				$nouveauDom = array();
				$playerDom = array();
				$noteLEDom = array();
				$noteFFDom = array();
				$noteSPDom = array();
				$noteDDom = array();
				$noteEDom = array();
				
				$penObtenuDom = array();
				$minDom = array();
					
				for ($i=0;$i<14;$i++) {
					$currPrestationDom = Array('id' => '', 'joueur_id' => '', 'note_lequipe' => '', 'note_ff' => '', 'note_sp' => '', 'note_d' => '', 'note_e' => '', 'penalty_obtenu' => '0', 'minutes' => '90', 'arrets' => '0', 'encaisses' => '0');
					$nouveau = 1;
					if (isset($storedPrestationsDomQuery[$i])){
						$currPrestationDom = $storedPrestationsDomQuery[$i];
						$nouveau = 0;
					}
					echo "<tr>";
					echo '<td>'.($i+1);
					echo "<input type=\"hidden\" name=\"nouveauDom[{$i}]\" value=\"{$nouveau}\"/><input type=\"hidden\" name=\"idDom[{$i}]\" value=\"{$currPrestationDom['id']}\"/></td>";
					echo "<td>";
					echo "<select size=\"1\" name=\"playerDom[{$i}]\" >";
					echo "<option value=\"\"> </option>";
					if ($loadJoueursDomQuery != NULL) {
						foreach($loadJoueursDomQuery as $joueurDom) {
							$selected = ($currPrestationDom['joueur_id'] == $joueurDom[0]);
							echo "<option value=\"{$joueurDom[0]}\" ";
							if ($selected) {
									echo "selected ";
								}
							echo ">{$joueurDom[2]} {$joueurDom[1]}</option>";
						}
					}
					echo "</select></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"minDom[{$i}]\" value=\"{$currPrestationDom['minutes']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"noteLEDom[{$i}]\" value=\"{$currPrestationDom['note_lequipe']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"noteFFDom[{$i}]\" value=\"{$currPrestationDom['note_ff']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"noteSPDom[{$i}]\" value=\"{$currPrestationDom['note_sp']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"noteDDom[{$i}]\" value=\"{$currPrestationDom['note_d']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"noteEDom[{$i}]\" value=\"{$currPrestationDom['note_e']}\"/></td>";
					$penoObt = intval($currPrestationDom['penalty_obtenu']);
					// On retranche des penaltys obtenus ceux qui ont été marqués afin de ne pas compter deux fois ceux-ci lors du calcul.
					if (($penoObt > 0) && ($nouveau == 0)) {
						$transformesQuery=$db->getArray("select count(id) from buteurs where rencontre_id={$_GET['matchId']} and penalty=1 and passeur_id={$currPrestationDom['joueur_id']}");
						$penoObt -= $transformesQuery[0][0];
					}
					echo "<td><input type=\"text\" size=\"2\" name=\"penObtenuDom[{$i}]\" value=\"{$penoObt}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"arretsDom[{$i}]\" value=\"{$currPrestationDom['arrets']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"encaissesDom[{$i}]\" value=\"{$currPrestationDom['encaisses']}\"/></td></tr>";
				}
			?>
		</table>
		<br/>
		<p><b>Extérieur:</b></p>
		<table class="tableau_liste_centre">
			<tr>
				<th></th><th>Joueur</th><th>Tps de jeu</th><th>L'Eq.</th><th>WhoSc.</th><th>-</th><th></th><th>-</th><th>Peno obtenu<br/>non marqué</th><th>Arrêts</th><th>Encaissés</th>
			</tr>
			<?php
				$idExt = array();
				$nouveauExt = array();
				$playerExt = array();
				$noteLEExt = array();
				$noteFFExt = array();
				$noteSPExt = array();
				
				$noteDExt = array();
				$noteEExt = array();
				$penObtenuExt = array();
				for ($i=0;$i<14;$i++) {
					$currPrestationExt = Array('id' => '', 'joueur_id' => '', 'note_lequipe' => '', 'note_ff' => '', 'note_sp' => '', 'note_d' => '', 'note_e' => '', 'penalty_obtenu'=>'0', 'minutes'=>'90', 'arrets' => '0', 'encaisses' => '0');
					$nouveau = 1;
					if (isset($storedPrestationsExtQuery[$i])){
						$currPrestationExt = $storedPrestationsExtQuery[$i];
						$nouveau = 0;
					}
					echo "<tr>";
					echo '<td>'.($i+1);
					echo "<input type=\"hidden\" name=\"nouveauExt[{$i}]\" value=\"{$nouveau}\"/><input type=\"hidden\" name=\"idExt[{$i}]\" value=\"{$currPrestationExt['id']}\"/>";
					echo "</td><td>";
					echo "<select size=\"1\" name=\"playerExt[{$i}]\" >";
					echo "<option value=\"\"> </option>";
					if ($loadJoueursExtQuery != NULL) {
						foreach($loadJoueursExtQuery as $joueurExt) {
							$selected = ($currPrestationExt['joueur_id'] == $joueurExt[0]);
							echo "<option value=\"{$joueurExt[0]}\" ";
							if ($selected) {
								echo "selected ";
							}
							echo ">{$joueurExt[2]} {$joueurExt[1]}</option>";
						}
					}
					echo "</select></td>";
						
					echo "<td><input type=\"text\" size=\"2\" name=\"minExt[{$i}]\" value=\"{$currPrestationExt['minutes']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"noteLEExt[{$i}]\" value=\"{$currPrestationExt['note_lequipe']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"noteFFExt[{$i}]\" value=\"{$currPrestationExt['note_ff']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"noteSPExt[{$i}]\" value=\"{$currPrestationExt['note_sp']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"noteDExt[{$i}]\" value=\"{$currPrestationExt['note_d']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"noteEExt[{$i}]\" value=\"{$currPrestationExt['note_e']}\"/></td>";
					$penoObt = intval($currPrestationExt['penalty_obtenu']);
					// On retranche des penaltys obtenus ceux qui ont été marqués afin de ne pas compter deux fois ceux-ci lors du calcul.
					if (($penoObt > 0) && ($nouveau == 0)) {
						$transformesQuery=$db->getArray("select count(id) from buteurs where rencontre_id={$_GET['matchId']} and penalty=1 and passeur_id={$currPrestationExt['joueur_id']}");
						$penoObt -= $transformesQuery[0][0];
					}
					echo "<td><input type=\"text\" size=\"2\" name=\"penObtenuExt[{$i}]\" value=\"{$penoObt}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"arretsExt[{$i}]\" value=\"{$currPrestationExt['arrets']}\"/></td>";
					echo "<td><input type=\"text\" size=\"2\" name=\"encaissesExt[{$i}]\" value=\"{$currPrestationExt['encaisses']}\"/></td></tr>";
					echo "</tr>";
				}
			?>
		</table>
		
		<input type="hidden" name="clubDomId" value="<?php echo ($loadClubsQuery[0]['club_dom_id']); ?>"/>
		<input type="hidden" name="clubExtId" value="<?php echo ($loadClubsQuery[0]['club_ext_id']); ?>"/>
		<input type="hidden" name="matchId" value="<?php echo ($_GET['matchId']); ?>"/>
		<input type="submit" value="Sauver"/>
	</form>
</div>