<?php
define ("REG", 1);
?>	

<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8" />
		<title> Регистрация.Магазин online-игр. </title>
		<link rel="stylesheet" href="/css/style.css">
		 <script>
   function agreeForm(f) {
    // Если поставлен флажок, снимаем блокирование кнопки
    if (f.flag_store.checked)  f.store.disabled = 0; 
    // В противном случае вновь блокируем кнопку
    else {f.store.disabled = 1; 
	f.store.value = "";}
   }
  </script>
	</head>
<body>
	<div class="content">
		
		<h1 class="z1"> Регистрация</h1>
		<p > Заполните все поля обязательны для заполнения</p>
		<form action="reg_action.php" method="POST">
			<input type = "text" name="nickname" required placeholder="Nickname"></br>
			<input type="password" name="password" required placeholder="Password"></br>
			<input type="password" name="r_password" required placeholder="Repeat password"></br> 
			<input type = "email" name="mail" required placeholder="Email"></br>
			<input id = "f_store" type="checkbox" name="flag_store" onclick="agreeForm(this.form); document.getElementById('f_store').value='accepted';">  Я представляю магазин.</br>
			<input type = "text" name="store" required placeholder="Site of store" disabled></br>
			<input type = "number" name="wmid" required placeholder="WMID"></br>
			<input type = "text" name="skype" required placeholder="Skype nickname"></br>
			<input type = "text" name="icq" required placeholder="ICQ UID"></br>
			<a href="rule.php"> Правила</a> сервиса.</br>
			<input id="rule" type="checkbox" onClick="document.getElementById('rule').value='accepted';" name="rule"> С правилами ознакомился и согласен!</br>
			<input name="submit" type="submit" value="Зарегистрироваться">
		</form>
		
		<footer>
		
		</footer>
	</div>
</body>
</html>