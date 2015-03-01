<?
// number of second the script allowed to run. setting to 6 minutes
$limit = 360;
$time = time();

// getting last loaded value
$last_id = (int)$_GET['id'];

// just to be sure that script will be killed
set_time_limit($limit+5);

mysql_connect('localhost','root','');
mysql_select_db('gamestore');

function escape($str) {
    return str_replace('"','\"',$str);
}

// цикл, проверяющий новые сообщения каждые 5 секунд
while (time()-$time<$limit) {
    // checking if something new was added to my test table
    $res = mysql_query('SELECT * FROM `users_farm` WHERE `id`>"'.$last_id.'" ORDER BY `id` ASC');
    if (mysql_num_rows($res)) {
        while ($item=mysql_fetch_array($res)) {
            // пишем js-скрипт, который выполнится у клиента
			echo 'self.putMessage("'.$item['id'].'","'.$item['username'].'","'.escape($item['game']).'","'.escape($item['server']).'","'.escape($item['amount']).'");';
        }
        // выбрасываем все данные и выходим, чтобы клиент смог их обработать
        flush();
        exit;
    }
    // если данных нет - ждём 5 секунд
    sleep(5);
}

mysql_close();



/*
$filename = dirname(__FILE__)."/data.txt";
 
$lastmodif = isset($_GET['timestamp']) ? $_GET['timestamp'] : 0;
$currentmodif = filemtime($filename);
 
while ($currentmodif <= $lastmodif)
{
    usleep(10000);
    clearstatcache();
    
    $currentmodif =  filemtime($filename);
    
} 
 
$response = array();
 
$response['msg'] = file_get_contents($filename);
$response['timestamp'] = $currentmodif;
 
echo json_encode($response);
*/?>	
