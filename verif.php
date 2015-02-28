<?php
	
	include ("config.php");
	if(isset($_GET['ver']) AND isset($_GET['key'])){
		if (!preg_match("/^[a-z0-9]+$/",$_GET['ver']) OR strlen($_GET['ver'])!=12){
			$err[] = "Хватит жульничать!";
			echo "1";
		}
		
		if (!preg_match("/^[a-f0-9]+$/",$_GET['key']) OR strlen($_GET['key'])!=32){
			$err[] = "Хватит жульничать!";
			echo "2";
		}
		
		if(count($err) == 0){
			$hash =  mysqli_real_escape_string($con,htmlspecialchars($_GET['ver']));
			$key =  mysqli_real_escape_string($con,htmlspecialchars($_GET['key']));
			$query = mysqli_query($con, "SELECT * FROM `users` WHERE `hash` ='".$hash."'");
			if(mysqli_num_rows($query)){
				$res = mysqli_fetch_array($query, MYSQLI_NUM);
				if (md5($hash.md5($res[1].$res[3])) == $key){
					mysqli_query($con,"UPDATE `users` SET `verification`= 1 WHERE `hash` ='".$hash."'");
					mysqli_query($con,"UPDATE `users` SET `hash`= 0 WHERE `hash` ='".$hash."'");
					echo 'Адрес электронной почты успешно подтвержден!<br />';
					echo '<br /><a href="index1.php"> Перейти на сайт! </a>';
				}
				else{
					echo "Что-то пошло не так!<br/>";
					echo md5($hash.md5($res[1].$res[3]));
					echo '<br/>'.$res[1].'<br/>'.$res[3].$hash.'<br/>'.$key;
				}
		}		
			
		}
		else{
			foreach($err AS $error){
				print $error."<br>";
			}
		}
    		
	}
?>