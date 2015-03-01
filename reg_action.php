<?php
	function generateCode($length = 12){
		$chars = 'abdefhiknrstyz1234567890';
		$numChars = strlen($chars);
		$string = '';
		for ($i = 0; $i < $length; $i++){
			$string .= substr($chars, rand(1, $numChars) - 1, 1);
		}
		return $string;
	}
	
	include ("config.php");
	if(isset($_POST['submit'])){
		$err = array();
		if (!preg_match("/^[a-zA-Z0-9]+$/",$_POST['nickname'])){
			$err[] = "Лoгин должен состоять только из букв английского алфавита, цифр и знака подчеркивания!";
		}
		if (strlen($_POST['nickname'])<3 OR strlen($_POST['nickname'])>30){
			$err[] = "Логин должен быть от 3 до 30 символов.";
		}
		if ($_POST['password'] != $_POST['r_password']){
			$err[] = "Пароли не совпадают!";
		}
		$login =  mysqli_real_escape_string($con,htmlspecialchars($_POST['nickname'])); 
		$query = mysqli_query($con, "SELECT `id` FROM `users` WHERE `username` ='".$login."'");
		if(mysqli_num_rows($query) > 0){
				$err[] = "Пользователь с таким логином уже зарегистрирован!";
			}		
		if(!preg_match("/^[\._a-zA-Z0-9-]+@[\.a-zA-Z0-9-]+\.[a-z]{2,6}$/i", $_POST['mail'])){
			$err[] = "Введен некорректный email!";
		}
		$mail = mysqli_real_escape_string($con,htmlspecialchars($_POST['mail'])); 
		$query = mysqli_query($con, "SELECT `id` FROM `users` WHERE  `email` ='".$mail."'");
		if(mysqli_num_rows($query) > 0){
				$err[] = "Пользователь с таким email уже зарегистрирован!";
			}		
		if (empty($_POST['password']) OR empty($_POST['r_password']) OR 
			empty($_POST['mail']) OR empty($_POST['wmid']) OR
			empty($_POST['skype']) OR empty($_POST['icq'])){
			$err[] = "Заполните все поля!";			
		}
		if (!preg_match("/^[0-9]+$/",$_POST['icq']) OR strlen($_POST['icq'])<6 OR strlen($_POST['icq'])>10){
			$err[] = "UIN ICQ должен содержать только числа. Длина должна быть в пределах от 6 до 10 символов!";
		}
		if (!preg_match("/^[0-9]+$/",$_POST['wmid']) OR strlen($_POST['wmid']) != 12){
			$err[] = "WMID должен содержать только числа. Длина должна быть 12 символов!";
		}
		if (!preg_match("/^[a-zA-Z0-9_]+$/",$_POST['skype']) OR strlen($_POST['skype'])>30){
			$err[] = "Логин skype должен состоять только из букв английского алфавита, цифр и знака подчеркивания!";
		}
		if ($_POST['rule']!='accepted'){
			$err[] = "Если вы не согласны с правилами, мы не можем вас зарегистрировать!";
		}
		if ($_POST['flag_store'] == 'accepted'){
			if(strlen($_POST['store'])== 0 )
				$err[] = "Следует ввести сайт или название магазина"; 
			else if (strlen($_POST['store'])<3)
					$err[] = "Какой-то подозрительный магазин!";
		}

		if(count($err) == 0){
			$password = md5($_POST['password']);
			$wmid =  mysqli_real_escape_string($con,htmlspecialchars($_POST['wmid']));
			$skype =  mysqli_real_escape_string($con,htmlspecialchars($_POST['skype']));
			$icq =  mysqli_real_escape_string($con,htmlspecialchars($_POST['icq']));
			if ($_POST['flag_store'] == 'accepted')
				$f_store = 1;
			else
				$f_store = 0;
			$store = mysqli_real_escape_string($con,htmlspecialchars($_POST['store']));
			$ver = generateCode();
			$key = md5($ver.md5($login.$mail));
			$link = "http://pm-pu.ru/gamestore/verif.php?ver=".$ver."&key=".$key;
			mysqli_query($con,"INSERT INTO `users` SET `username`='".$login. "', `password`='".$password. "', `email`='".$mail. "', `store`='".$store. "', `f_store`='".$f_store. "', `wmid`='".$wmid. "', `skype`='".$skype. "', `icq_uin`='".$icq.  "', `hash`='".$ver. "'");
			//header("Location: index1.php");exit();
			
			//Готовим письмо
			// Готовим разделитель
			$un = strtoupper(uniqid(time()));	

			// Ящик отправителя
			$from = "no-reply@".$_SERVER['HTTP_HOST'];

			// Заголовок письма
			$headers = "From: ".$from."\r\nReply-To: ".$from."\r\nContent-type: text/plain; charset=windows-1251 \r\n";

			// Тема письма
			$subject = "Подтверждение регистрации на сайте!";

			//// Готовим тело письма
			
			// Текст письма
			$letter = "Для подтверждения регистрации перейдите по ссылке:".$link."\r\nЕсли вы не регистрировались на сайте, просто игнорируйте это письмо!";
			// Формируем тело письма
			$body = $letter;
			$subject = iconv("utf-8", "cp1251", $subject);
			$body = iconv("utf-8", "cp1251", $body);
			$headers = iconv("utf-8", "cp1251", $headers);
			// Оправляем письмо
			$sucess = mail($mail, $subject, $body, $headers); 
			
			echo 'На ваш email отправлено письмо для подтверждения регистрации!<br />';
			echo '<br /><a href="index1.php"> Перейти на сайт!</a>';
			
		}
		else{
			print "<b>При регистрации произошли следующие ошибки:</b><br>";
			foreach($err AS $error){
				print $error."<br>";
			}
			echo "</br><a href=\"reg.php\"> На страницу регистрации!</a>";
		}
    		
	}
?>