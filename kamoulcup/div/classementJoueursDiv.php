<div class='classement'>
		<b>Classement joueurs </b><a href="index.php?page=classementJoueurs">[voir tout]</a>
		<!--<table width='300px' border=0 class='tableau_class liencolonne' cellpading='0' cellspacing='0'>-->
		<table>
		<?php
				$meilleursJoueursQuery = $db->getArray("select id,nom,prenom,score,score1,poste from joueur order by score desc limit 10");
				$i=0;
				$lastScore = -1;
				foreach($meilleursJoueursQuery as $joueur) {
					$i++;
					$scoreFl = number_format(round(floatval($joueur['score']),2),2);
					$rang = $i;
					if ($scoreFl == $lastScore) {
						$rang = '-';
					}
					echo "<tr height='22px'><td>{$rang}</td><td><a href=\"index.php?page=detailJoueur&joueurid={$joueur['id']}\">{$joueur['prenom']} {$joueur['nom']}</a></td><td>{$joueur['poste']}</td><td align='right'>{$scoreFl}</td></tr>";
					$lastScore = $scoreFl;
				}
		?>
		</table>
</div>