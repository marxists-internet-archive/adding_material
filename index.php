<?php 
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}
# Соединямся с БД
include("config.php");

//если обращаемся к неглавной странице сайта
if (($_SERVER['REQUEST_URI'] != '/') and ($_SERVER['REQUEST_URI'] != '/index.php') ){	
	$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			
	$uri_parts = explode('/', trim($url_path, ' /'));
			
	$name = array_shift($uri_parts); //Получили имя пользователя
	$query = mysqli_query($con,"SELECT * FROM `users` WHERE username='".mysqli_real_escape_string($con,$name)."'");
	$data = mysqli_fetch_assoc($query); 
	// если такой юзер есть, то сохраняем его номер
	if(mysqli_num_rows($query) > 0)
		$id_user = $data['id'];
	else{
		//на 404 страницу с ошибкой
		header("Location: index2.php"); exit;
	}			
}


if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){  			//если есть куки нашего сайта
	$query = mysqli_query($con, "SELECT * FROM `users` WHERE id = '".intval($_COOKIE['id'])."'");
	$userdata = mysqli_fetch_assoc($query);

	if(($userdata['hash1'] == $_COOKIE['hash']) and ($userdata['id'] == $_COOKIE['id'])){ //если куки верные, авторизованный пользователь
		if (!empty($id_user)){															  //если есть имея юзера в URL
			$query = mysqli_query($con, "SELECT `username` FROM `users` WHERE id = '".$id_user."'");
			$userdata = mysqli_fetch_assoc($query);
			
			
			//header("Location: index1.php"); exit;
			if ($id_user == $_COOKIE['id']) 
				echo "<h2>".$userdata['username']." это ваш магазин! </h2>";
			else 
				echo '<h2> Магазин юзера '.$userdata['username'].' </h2>';
			
			echo "В наличии<br />";
				
			if ($query = mysqli_query($con,"SELECT * FROM `users_farm` WHERE user_id='".$id_user."'")) {
				/* извлечение ассоциативного массива */
				while ($row = mysqli_fetch_assoc($query)) {
					printf ("GAME: %s SERVER: %s AMOUNT: %d <br />", $row['game'], $row['server'], $row['amount']);
				}
			}
			if ($id_user == $_COOKIE['id']) 
				echo "<br />Редактировать информацию!";
			
			echo '<br/><a href="unlog.php"> !!Выйти!!</a>';
		}
		else{  //если имени юзера нет, то уходим в общий магазин
			header("Location: store.php"); exit;		
		}
	}
}
else { // если куков сайта нет
	if(isset($_POST['submit'])){ //может он хотел авторизоваться, если если да то пробуем авторизовать
 			$err=1;
		# Вытаскиваем из БД запись, у которой логин равняеться введенному
		$query = mysqli_query($con,"SELECT `id`, `password` FROM `users` WHERE username='".mysqli_real_escape_string($con,$_POST['login'])."'");
		$data = mysqli_fetch_assoc($query);
		# Сравниваем пароли
		if($data['password'] === md5($_POST['password'])){
			# Генерируем случайное число и шифруем его
			$hash = md5(generateCode(10));
			# Записываем в БД новый хеш авторизации
			mysqli_query($con, "UPDATE `users` SET `hash1`='".$hash."' WHERE `id`='".$data['id']."'");
			# Ставим куки
			setcookie("id", $data['id'], time()+60*60*24*30);
			setcookie("hash", $hash, time()+60*60*24*30);
			header("Location: index.php"); exit;
		}
		else {
			$err =1;
		}
	}
	else{ // если он просто зашел на сайт или хуйню написал в авторизации
		if (!empty($id_user)){  //если он написал ссылку на магаз
 			echo "Магазин юзера ".$data['username']."<br />";
			echo "В наличии<br />";
				
			if ($query = mysqli_query($con,"SELECT * FROM `users_farm` WHERE user_id='".$id_user."'")) {
				/* извлечение ассоциативного массива */
				while ($row = mysqli_fetch_assoc($query)) {
					printf ("GAME: %s SERVER: %s AMOUNT: %d <br />", $row['game'], $row['server'], $row['amount']);
				}
			}
		}		
		else { //если нихуя не ввёл, то выводим ему общую страницу.
			echo'
					<!DOCTYPE html>
			<html lang="ru">
				<head>
					<meta charset="utf-8" />
					<title> Магазин online-игр </title>
					<link rel="stylesheet" href="/css/style.css">
				</head>
			<body>
				<div class="content">
					
					<h1 class="main"> Что это такое?</h1>
					<p > Наш сайт призван облегчить всем тем, кто играет в online-игры.</p>
					<h1 class="main">Это как? </h1>
					<p> У нас вы всегда сможете купить/продать игровую валюту в таких играх, как Linage 2, ArcheAge и World of Warcraft. Удобная система поиска и всегда актуальный список проверенных продавцов. </p>
					<h1 class="main"> А если я сам продавец?</h1>
					<p> В таком случае, мы предлагаем вам открыть у нас свой личный магазин. Личная страница, на которой вы король. Указывайте где и что у вас есть и сами устанавливайте цены. Возможность продавать как лично, так и через общий каталог. Больше нужно постоянно сидеть в Skype, ICQ. Не нужно каждому описывать где и сколько фармы у вас есть, теперь достаточно просто поделиться ссылкой на ваш личный магазин gamestore.com/agent/ВАШ_НИК. Быстро. Просто. Надежно. </p>
					
					<a href="reg.php"><img src="i/registration.png"></a>
					<h2>Нас уже:</h2>
					<ul>
						<li>Продавцов: 120 </li>
						<li>Покупателей: 750</li>
						<li>Сделок: 2983 </li>
					</ul>
			';
		}
		if ($err == 1)	
			echo' Вы ввели неправильный логин или пароль! <br />';
		
		echo'
						<form method="POST">
						Логин <input name="login" type="text"><br>
						Пароль <input name="password" type="password"><br>
						<input name="submit" type="submit" value="Войти">
					</form>
					<footer>
					
					</footer>
				</div>
			</body>
		</html>
		';
	}
}

?>

