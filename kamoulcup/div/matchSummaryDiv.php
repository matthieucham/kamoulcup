<?php
	$getMatchQuery = $db->getArray("select cl1.nom,cl1.id_lequipe,cl2.nom,cl2.id_lequipe,re.buts_club_dom,re.buts_club_ext from rencontre as re, club as cl1, club as cl2 where re.id='{$_GET['matchId']}' and re.club_dom_id=cl1.id and re.club_ext_id=cl2.id limit 1");
?>
<div class="sectionPage">
	<div id="matchSummary">
	<?php
	$imgUrl = getURLLogoClubSmall($getMatchQuery[0][1]);
	$imgUrl2 = getURLLogoClubSmall($getMatchQuery[0][3]);
	echo "<img src=\"{$imgUrl}\"/> {$getMatchQuery[0][0]} {$getMatchQuery[0][4]} - {$getMatchQuery[0][5]} {$getMatchQuery[0][2]} <img src=\"{$imgUrl2}\"/>";
	?>
	</div>
</div>