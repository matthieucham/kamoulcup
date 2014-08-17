<div class='classement'>
		<b>Sessions en cours</b>
		<a href="index.php?page=showClosedSession">[voir sessions terminées]</a>
		<!--<table width='300px' border=0 class='tableau_class liencolonne' cellpading='0' cellspacing='0'>-->
		<table>
		<?php
				$listPoulesQuery = $db->getArray("select id,nom from poule");
				
				foreach($listPoulesQuery as $poule) {
					$listSessionsQuery = $db->getArray("select id,numero,date_format(date_pas,'%d/%m %H:%i'),date_format(date_encheres,'%d/%m %H:%i'),date_format(date_resolution,'%d/%m %H:%i'),(date_encheres < now()) from session where poule_id='{$poule['id']}' and (date_resolution - now() >= 0) and (date_pas - now() < 0) order by numero");
					if ($listSessionsQuery != NULL) {
						foreach($listSessionsQuery as $session) {
							$etat = "Enchères en cours";
							$datelimite = $session[4];
							if ($session[5] == 0) {
								$etat = "PAs en cours";
								$datelimite = $session[3];
							}
							echo "<tr height='22px'><td><a href=\"index.php?page=detailSession&sessionid={$session[0]}\"><b>Num. {$session[1]}</b></a> {$poule[1]} - {$etat} jusqu'au {$datelimite}</td></tr>";
						}
					}
				}
		?>
		</table>
</div>