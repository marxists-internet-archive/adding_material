<?php
	include ("config.php");
	if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])){ 
			$query = mysqli_query($con, "SELECT * FROM `users` WHERE id = '".intval($_COOKIE['id'])."'");
			$userdata = mysqli_fetch_assoc($query);

			if(($userdata['hash1'] !== $_COOKIE['hash']) or ($userdata['id'] !== $_COOKIE['id'])){
				header("Location: unlog.php"); exit;
			}
			else{
				echo '<h2> Общий магазин!ЕБана рот!</h2><br/>';
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
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" >
function soundClick() {
	var audio = new Audio(); // —оздаЄм новый элемент Audio
	audio.src = 'zv.wav'; // ”казываем путь к звуку "клика"
	audio.autoplay = true; // јвтоматически запускаем
}

function Messanger() {
//alert('start1');
    this.last = 0;
    this.timeout = 360;
    this.comet = 0;
    var self = this;
    this.putMessage = function(id,name,text) {
		//alert("putMessage"+id+name+text);
		soundClick();
        // callback, добавляет сообщения на страницу, вызывается из полученных с сервера данных
        self.last = id;
        var b = document.createElement('div');
        b.innerHTML = '<span style="color: red;">'+name+'</span> '+text;
		$('#messages').append(b);
		
    }
    this.parseData = function(message){
//alert("parse "+message);
        // простая обработка данных полученных с сервера, разбиваем строки и выполняет функции
        var items = message.split(';');
        if (items.length<1) return false;
        for (var i=0;i<items.length;i++) {
            eval(items[i]);
        }
        setTimeout(self.connection,1000);
    }
    this.connection = function() {
	//	alert('connect');
    // здесь открывается соединение с сервером
        self.comet = $.ajax({
                type: "GET",
                url:  "comet.php",
                data: {'id':self.last, 'id_user':document.cookie},
                dataType: "text",
                timeout: self.timeout*1000,
                success: self.parseData,
                error: function(){
                    // something wrong. but setInterval will set up connection automatically
                    setTimeout(self.connection,1000);
               }
            });
    }
    this.init = function() {
        //setInterval(self.connection,self.timeout*1000);
        self.connection();
    }
    this.init();
}



$(document).ready(function(){
//alert('start');
    // инициализация
    var msg = new Messanger();
	


});
</script>
		
	</head>
<body>
	<div class="content">
		
		<h1 class="main"> Добро пожаловать а магазин!</h1>
		<div id="messages">
		</div>
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