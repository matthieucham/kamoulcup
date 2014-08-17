<?php
// $allJoueurs : le gros tableau
// $rankIndex : l'index du pick
// $storedPick : le pick enregistré auparavant
$currentPickId = -1;
if (isset ($storedPick)) {
	$currentPickId= $storedPick['id'];
}
?>
<tr>
	<td><?php echo ($rankIndex+1);?> <input type='hidden'
		name='pickIds[<?php echo $rankIndex; ?>]'
		value='<?php echo $currentPickId; ?>' /></td>
	<td><select size=1 name="<?php echo "pickJoueurs[{$rankIndex}]";?>">
	<?php
	foreach($allJoueurs as $joueur) {
		$selected = false;
		if (isset($storedPick) && $storedPick != NULL)
		{
			$selected = ($storedPick['joueur_id'] == $joueur['joueurId']);
		}
		echo "<option";
		if ($selected) {
			echo " selected ";
		}
		$poste = traduire($joueur['poste']);
		echo " value='{$joueur['joueurId']}'>{$joueur['prenom']} {$joueur['nomJoueur']} ({$poste}, {$joueur['nomClub']})</option>";
	}
	?>
	</select> <?php
	echo "<input type=\"hidden\" name=\"pickDesc[{$rankIndex}]\" value=\"{$joueur['prenom']} {$joueur['nomJoueur']} ({$poste}, {$joueur['nomClub']})\"/>";
	?></td>
</tr>
