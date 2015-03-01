<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="utf-8" />
		<title> Магазин online-игр </title>
		<link rel="stylesheet" href="/css/style.css">
		<script src="http://code.jquery.com/jquery-latest.js"></script>
		
		<script type="text/javascript" >
 function loadserver(select){
    var serverSelect = $('select[name="server"]');
    serverSelect.attr('disabled', 'disabled'); // делаем список городов не активным

    // послыаем AJAX запрос, который вернёт список городов для выбранной области
    $.getJSON('form_store.php', {action:'getserver', game:select.value}, function(serverList){
                
		serverSelect.html(''); // очищаем список городов
                
		// заполняем список городов новыми пришедшими данными
		$.each(serverList, function(i){
			serverSelect.append('<option value="' + this + '">' + this + '</option>');
		});
                
		serverSelect.removeAttr('disabled'); // делаем список городов активным
                
    });
}

		
function soundClick() {
	var audio = new Audio(); //  новый элемент Audio
	audio.src = 'zv.wav'; // ”казываем путь к звуку "клика"
	audio.autoplay = true; // јвтоматически запускаем
}

// возвращает cookie с именем name, если есть, если нет, то 0
function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : 0;
}

function Messanger() {
//alert('start1');
    this.last = 0;
    this.timeout = 360;
    this.comet = 0;
	id_store = getCookie('id_store');
    var self = this;
    this.putMessage = function(id,name,game,server,num) {
		//alert("putMessage"+id+name+game);
		if ( id <= id_store) {}
		else{
			soundClick();
			var date = new Date( new Date().getTime() + 2*3600*1000 );
			document.cookie="name=value; path=/; expires="+date.toUTCString();

			document.cookie = "id_store="+id+"expires=";
        }
		// callback, добавляет сообщения на страницу, вызывается из полученных с сервера данных
        self.last = id;
        var b = document.createElement('div');
        b.innerHTML = 'Поставщик: '+name+' закупит:<span style="color: red;"> в '+game+' </span>  на сервере:'+server+'  вот столько '+num+' золота';
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
		<?php		
			echo '<h2> Общий магазин!</h2><br/>';
			print "Привет, ".$userdata['username'].". Всё работает!";
			
			if ($userdata['verification'] == 0){
				echo '<h2> Ваш email не подтвержден!!!</h2>';
			}
			if ($userdata['f_store'] == 1){
				echo " Вы можете добавить сообщение в чат!";
				require ('form_store.php');
			}
		?>
		
		<br/><a href="unlog.php"> !!Выйти!!</a>
		
		<footer>
		
		</footer>
	</div>
</body>
</html>