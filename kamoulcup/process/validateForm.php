<?php
	
	function correctSlash($param) {
		$temp = $param;
		if (!get_magic_quotes_gpc()) {
			$temp = addslashes($param);
		}
		return $temp;
	}
	
	function valideInt($paramEntier, $fieldId, $pageName) {
		if ($paramEntier != strval(intval($paramEntier))) {
			$err="{$fieldId}: Entier attendu.";
			//header("Location: ../index.php?page={$pageName}&ErrorMsg={$err}");
			echo "<script>window.location.replace('../index.php?page={$pageName}&ErrorMsg={$err}');</script>";
			exit();
		}
	}
	
	function valideFloat($paramFloat, $fieldId, $pageName) {
		if ($paramFloat != strval(floatval($paramFloat))) {
			$err="{$fieldId}: Valeur décimale attendue.";
			//header("Location: ../index.php?page={$pageName}&ErrorMsg={$err}");
			echo "<script>window.location.replace('../index.php?page={$pageName}&ErrorMsg={$err}');</script>";
			exit();
		}
	}
	
	function valideString($paramString, $fieldId, $pageName) {
		if (strlen(trim($paramString)) == 0) {
			$err="{$fieldId}: Valeur obligatoire.";
			//header("Location: ../index.php?page={$pageName}&ErrorMsg={$err}");
			echo "<script>window.location.replace('../index.php?page={$pageName}&ErrorMsg={$err}');</script>";
			exit();
		}
	}
?>