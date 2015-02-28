<?php
	if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){
		setcookie("id", "", time()-60*60*24*30);
		setcookie("hash", " ", time()-60*60*24*30);
	}
	header("Location: index.php"); exit;
?>