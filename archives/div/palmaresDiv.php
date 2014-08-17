

<?php
$listPalmaresQuery = $db->getArray("select titre,vainqueur,vainqueur_score,vainqueur_roster,deuxieme,deuxieme_score,deuxieme_roster,troisieme,troisieme_roster,troisieme_score,url_site,sql_backup_filename,zip_backup_filename from palmares where type='L1' order by date_competition desc");
if ($listPalmaresQuery != NULL) {
	foreach($listPalmaresQuery as $palmares) {
		$scor1 = number_format(round($palmares['vainqueur_score'],2),2);
		$scor2 = number_format(round($palmares['deuxieme_score'],2),2);
		$scor3 = number_format(round($palmares['troisieme_score'],2),2);
		?>
<div class='sectionPage'>
<div class='titre_page'><?php echo $palmares['titre']; ?></div>

<div class='palmares_right_container'>
<?php
if (strlen($palmares['url_site']) > 0) {
	echo "<p class='mainURL'>&nbsp;<a href=\"{$palmares['url_site']}\">Accèder au site (archive)</a></p>";
}
if (strlen($palmares['sql_backup_filename']) > 0) {
	echo "<p>&nbsp;<a href=\"backups/{$palmares['sql_backup_filename']}\" target=\"_blank\">Télécharger le script BDD (mysql)</a></p>";
}
if (strlen($palmares['zip_backup_filename']) > 0) {
	echo "<p>&nbsp;<a href=\"backups/{$palmares['zip_backup_filename']}\" target=\"_blank\">Télécharger le code php de cette version</a></p>";
}
?>
</div>
<div class='palmares_podium_container'>
<div class="podium">
<div class="top">
<div class="first">1: <?php echo $palmares['vainqueur']; ?>&nbsp;&nbsp;<?php echo $scor1; ?></div>
<p><?php echo $palmares['vainqueur_roster']; ?></p>
</div>
<div class="left">
<div class="others">2: <?php echo $palmares['deuxieme']; ?>&nbsp;&nbsp;<?php echo $scor2; ?></div>
<p><?php echo $palmares['deuxieme_roster']; ?></p>
</div>
<div class="right">
<div class="others">3: <?php echo $palmares['troisieme']; ?>&nbsp;&nbsp;<?php echo $scor3; ?></div>
<p><?php echo $palmares['troisieme_roster']; ?></p>
</div>
</div>
</div>
<p>&nbsp;</p>
</div>
<?php
	}
}
?>
