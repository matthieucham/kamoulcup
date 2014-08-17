<?php
	include('checkAccess.php');
	checkAccess(1);
	include("../includes/db.php");
	include('validateForm.php');

	$nbVente = count($_POST['idVente']);
	for ($i=0;$i<$nbVente;$i++) {
		// Pour chaque vente on vérifie d'abord que le délai d'envoi des enchères n'est pas écoulé avant de prendre en compte toute modif.
		$getDelaiEnchereQuery = $db->getArray("select unix_timestamp(date_soumission), unix_timestamp(date_finencheres) from vente where id={$_POST['idVente'][$i]} limit 1");
		if ((time() > $getDelaiEnchereQuery[0][0]) && (time() < $getDelaiEnchereQuery[0][1])) {
			// D'abord les annulations	
			if ($_POST['annulVente'][$i]) {
				//DELETE
				$db->query("delete from enchere where id='{$_POST['idEnchere'][$i]}'") or die("Delete query failed");
			} else {
				valideFloat(correctSlash($_POST['montantVente'][$i]),'montant '.$i,'editEncheres');
				$mt = floatval($_POST['montantVente'][$i]);
				if ($mt > 0) {
					$getVenteQuery = $db->getArray("select montant,type from vente where id='{$_POST['idVente'][$i]}' limit 1");
					if (($mt < $getVenteQuery[0]['montant']) 
						|| ($mt == $getVenteQuery[0]['montant'] && $getVenteQuery[0]['type'] == 'PA')) {	
						$err = addslashes("Le montant de l'enchère doit être supérieur au montant de mise en vente");
						echo "<script>window.location.replace('../index.php?page=editEncheres&ErrorMsg={$err}');</script>";
						exit();
					}
					if (intval($_POST['idEnchere'][$i]) > 0) {
						// UPDATE
						$db->query("update enchere set montant={$mt},date_envoi=now() where id='{$_POST['idEnchere'][$i]}'") or die("Update query failed");
					} else {
						// INSERT
						$db->query("insert into enchere(vente_id,date_envoi,auteur,montant) values ('{$_POST['idVente'][$i]}',now(),'{$_SESSION['myEkypId']}',$mt) ")  or die("Insert query failed");
					}
				}
			}
		} else {
			$err = addslashes("Il est trop tard pour enchérir sur cette vente");
			echo "<script>window.location.replace('../index.php?page=editEncheres&ErrorMsg={$err}');</script>";
			exit();
		}
	}
	header('Location: ../index.php?page=editEncheres');
	exit();
?>

