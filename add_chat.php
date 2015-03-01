<?php
	echo "nick". $_POST['user_id']." <br> game". $_POST['game']."<br> serv ".$_POST['server'] ."<br> adena=". $_POST['resource']."";
	include ("config.php");
	
	if (empty($_POST['user_id']) OR empty($_POST['game']) OR empty($_POST['server']) OR empty($_POST['resource'])){
		$err[] = "Заполните все поля!";			
	}
	
	if(count($err) == 0){
		$user_id =  mysqli_real_escape_string($con,htmlspecialchars($_POST['user_id']));
		$game =  mysqli_real_escape_string($con,htmlspecialchars($_POST['game']));
		$server =  mysqli_real_escape_string($con,htmlspecialchars($_POST['server']));
		$resource =  mysqli_real_escape_string($con,htmlspecialchars($_POST['resource']));
		
		mysqli_query($con,"INSERT INTO `users_farm` SET `user_id`='".$user_id. "', `game`='".$game. "', `server`='".$server. "', `amount`='".$resource. "'");
		
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