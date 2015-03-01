<?php
	echo "nick". $_POST['username']." <br> game". $_POST['game']."<br> serv ".$_POST['server'] ."<br> adena=". $_POST['resource']."";
	include ("config.php");
	
	if (empty($_POST['username']) OR empty($_POST['game']) OR empty($_POST['server']) OR empty($_POST['resource'])){
		$err[] = "Заполните все поля!";			
	}
	
	if(count($err) == 0){
		$username =  mysqli_real_escape_string($con,htmlspecialchars($_POST['username']));
		$game =  mysqli_real_escape_string($con,htmlspecialchars($_POST['game']));
		$server =  mysqli_real_escape_string($con,htmlspecialchars($_POST['server']));
		$resource =  mysqli_real_escape_string($con,htmlspecialchars($_POST['resource']));
		
		mysqli_query($con,"INSERT INTO `users_farm` SET `username`='".$username. "', `game`='".$game. "', `server`='".$server. "', `amount`='".$resource. "'");
		
		echo '<br />Заказ успешно добавлен. Через несколько секунд вы автоматически вернетесь в магазин.';
		echo '<script type="text/javascript">setTimeout(function(){location.replace("'.$_SERVER['HTTP_REFERER'].'");}, 3000);</script>';
				
		
	}
	else{
		print "<b>При добавлении сообщения произошли следующие ошибки:</b><br>";
			foreach($err AS $error){
				print $error."<br>";
			}
		echo '<br /> Через несколько секунд вы автоматически вернетесь в магазин.';
		echo '<script type="text/javascript">setTimeout(function(){location.replace("'.$_SERVER['HTTP_REFERER'].'");}, 3000);</script>';
		
	}
	
	
	
?>