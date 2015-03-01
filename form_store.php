<?php
$server = array (
  'Lineage II Classic' => array (
    0 => 'Gran Kain',
    1 => 'Server1',
  ),
  'ArchiAge' => array (
    0 => 'ServerAA1',
    1 => 'ServerAA2',
    2 => 'ServerAA3',
   
  ),
  'WoW' => array (
    0 => 'ServerWoW1',
    1 => 'ServerWoW2',
  ),
);

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// возвращаем список городов
if ($action == 'getserver')
{
    if (isset($server[$_GET['game']]))
    {
        echo json_encode($server[$_GET['game']]); // возвраащем данные в JSON формате;
    }
    else
    {
        echo json_encode(array('Выберите область'));
    }

    exit;
}
?>
<form action="add_chat.php" method="post">
	 <input type="hidden" name="username" value=" <?php echo $userdata['username'];  ?> " >
    <select name="game" onchange="loadserver(this)">
        <option></option>
            
        <?php
			// заполняем список областей
            foreach ($server as $game => $serverList){
                echo '<option value="' . $game . '">' . $game . '</option>' . "\n";
            }
			
        ?>
            
    </select>
        
    <select name="server" disabled="disabled">
        <option>Выберите игру</option>
    </select>
	<input type = "number" name="resource" required placeholder="Количество"></br>
    <input type="submit" value="отправить" />
    </form>