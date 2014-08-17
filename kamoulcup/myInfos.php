<?php
	checkAccess(1);
	checkEkyp();
	
	$getEkypQuery = $db->getArray("select po.nom as nomPoule, ek.nom, ek.logo, ek.budget, ek.presentation, ek.score from ekyp as ek, poule as po where ek.id='{$_SESSION['myEkypId']}' and ek.poule_id=po.id limit 1");
?>

	<div class="titre_page">
		<?php echo "Infos de l'ékyp: <a href='index.php?page=showEkyp&ekypid={$_SESSION['myEkypId']}'>{$getEkypQuery[0]['nom']}</a>"; ?>
	</div>
	<div class="section_page">
	<?php
		$infosQuery = $db->getArray("select date_format(info.date,'%d/%m %H:%i:%s') as dateInfo,info.type,info.complement_float,jo.id,jo.prenom,jo.nom,jo.club_id from info, joueur as jo where (info.ekyp_concernee_id={$_SESSION['myEkypId']} or info.ekyp_concernee_id=0) and info.joueur_concerne_id=jo.id order by info.date desc");
		if ($infosQuery == NULL) {
			echo "Pas d'infos récentes";
		} else {
			echo "<table class='tableau_horizon'>";
			foreach ($infosQuery as $info) {
				$type= traduire($info['type']);
				$club= 'les joueurs sans club';
				if ($info['club_id'] != NULL) {
					$clubQ = $db->getArray("select nom from club where id={$info['club_id']} limit 1");
					$club = $clubQ[0][0];
				}
				$texte= infotexte($info['type'],$info['id'],$info['prenom'],$info['nom'],$club,number_format(round($info['complement_float'],1),1));
				$pic = picto($info['type']);
				
				echo "<tr><td>{$info['dateInfo']}</td><td><img src='$pic'/></td><td>{$texte}</td>";
				if ($info['type'] == 'NO') {
					if (floatval($info['complement_float']) > 0) {
						$pictevol = "+{$info['complement_float']}<img src='images/arrow_up.gif'/>";
					} else {
						$pictevol = "{$info['complement_float']}<img src='images/arrow_down.gif'/>";
					}
					echo "<td>{$pictevol}</td>";
				}
				echo "</tr>";
			}
			echo "</table>";
		}
	?>
	</div>
	