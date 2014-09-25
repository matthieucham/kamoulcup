<section id="market">
<h1>Merkato</h1>
<div id="marketInfo" class="infobox">
	<p>Marché ouvert du 17/11 au 19/11</p>
</div>
<div id="budgetInfo">
	<h2></h2>
	<div class='budgetInfo_line'>
		<div class='budgetItem'><p>Contrats</p></div>
		<div class='budgetItem'>
			<div class='contract_positions_container'>
		<!--
		<div class='contract_position'>A<div class='pos_marker pos_marker_filled'></div></div>
		<div class='contract_position'>A<div class='pos_marker pos_marker_filled'></div></div>
		<div class='contract_position'>M<div class='pos_marker pos_marker_empty'></div></div>
		<div class='contract_position'>M<div class='pos_marker pos_marker_empty'></div></div>
		<div class='contract_position'>D<div class='pos_marker pos_marker_empty'></div></div>
		<div class='contract_position'>D<div class='pos_marker pos_marker_filled'></div></div>
		<div class='contract_position'>G<div class='pos_marker pos_marker_filled' title='Cédric Carrasso'></div></div>
		-->
		</div>
		</div>
	</div>
	<div class='budgetInfo_line'>
		<div class='budgetItem'>
			<p>Budget</p>
			<p><span class='budgetValue'></span></p>
		</div>
		<div class='budgetItem'>
			<p>Masse salariale</p>
			<p><span class='budgetValue'></span></p>
		</div>
	</div>
</div>
<div id='clubPlayersList'>
		<p><label for='clubSelect'>Club</label>
		<select id='clubSelect'></select></p>
	
	<div id='playersList_effectif' class='playersList'>
		<h2 id='selectedClubName'></h2>
		<ul id='playersList_list'>
		</ul>
	</div>
</div>
<div id='playersCart'>
	<h2>Mon panier</h2>
	<form id='cartForm' method="POST" action="#">
		<div id='cartContent' class='playersList'>
			<ul>
				<li class="placeholder">Faites glisser vos choix ici</li>
			</ul>
		</div>
		<div id='cartValue'>
			<p>Masse salariale disponible : <span></span> Ka</p>
			<p>Budget transfert restant : <span></span> Ka</p>
		</div>
		<button id="sendCartBtn">Envoyer</button>
	</form>
</div>
</section>
<script src="js/custom/km-market.js"></script>