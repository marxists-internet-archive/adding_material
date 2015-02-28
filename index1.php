<?php
	include ("config.php");
	if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){ 
			$query = mysqli_query($con, "SELECT * FROM `users` WHERE id = '".intval($_COOKIE['id'])."'");
			$userdata = mysqli_fetch_assoc($query);

			if(($userdata['hash1'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id'])){
				header("Location: unlog.php"); exit;
			}
			else{
				echo '<h2> Общий магазин!</h2><br/>';
				print "Привет, ".$userdata['username'].". Всё работает!";
				
				if ($userdata['verification'] == 0){
					echo '<h2> Ваш email не подтвержден!!!</h2>';
				}
			}
	}
	else{	//если куков нет, на главную бросаем
		unset($_SERVER['REQUEST_URI']);		
		header("Location: index.php"); exit;
		}
?>

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8" />
		<title> Магазин online-игр </title>
		<link rel="stylesheet" href="/css/style.css">
	</head>
<body>
	<div class="content">
		
		<h1 class="main"> Добро пожаловать а магазин!</h1>
		<h2>Нас уже:</h2>
		<ul>
			<li>Продавцов: 120 </li>
			<li>Покупателей: 750</li>
			<li>Сделок: 2983 </li>
		</ul>		
		
		<a href="unlog.php"> !!Выйти!!</a>
		
		<footer>
		
		</footer>
	</div>
</body>
</html>