<?php
	include ("config.php");
	if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){ 
			$query = mysqli_query($con, "SELECT * FROM `users` WHERE id = '".intval($_COOKIE['id'])."'");
			$userdata = mysqli_fetch_assoc($query);
			if(($userdata['hash1'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id'])){
				header("Location: unlog.php"); exit;
			}
			else{
				require('chat_store.php');
			}
	}
	else{	//если куков нет, на главную бросаем
		unset($_SERVER['REQUEST_URI']);		
		header("Location: index.php"); exit;
		}
?>
