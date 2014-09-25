<?php
$currentPage = 'home';
if (isset($_GET['kmpage'])) {
	$currentPage = $_GET['kmpage'];
}
?>
<header
	class="headerstandard headerstandard-shrink">
<div class="headerstandard-inner">
<h1>Kamoulcup Manager</h1>
<nav class="menu menustandard"> 
	<a
	<?php
		if ($currentPage == 'home') {
			echo " class='current' "; 
		} 
	?> 
	href="index.php?kmpage=home" id="menu-target-home">Maison</a> 
	<a
	<?php
		if ($currentPage == 'team') {
			echo " class='current' "; 
		} 
	?> 
	href="index.php?kmpage=team" id="menu-target-team">Franchise</a> 
	<a
	<?php
		if ($currentPage == 'fixtures') {
			echo " class='current' "; 
		} 
	?> 
	href="index.php?kmpage=fixtures" id="menu-target-fixtures">Compétition</a>
	<a 
	<?php
		if ($currentPage == 'market') {
			echo " class='current' "; 
		} 
	?> 
	href="index.php?kmpage=market" id="menu-target-market">Mercato</a> 
	<a
	<?php
		if ($currentPage == 'user') {
			echo " class='current' "; 
		} 
	?> 
	href="index.php?kmpage=user" id="menu-target-user">Utilisateur</a> 
</nav>
</div>
</header>
