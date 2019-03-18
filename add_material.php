<!DOCTYPE html>
<html>
<head>
<title>Результат добавления материала в русский раздел сайта marxists.org</title>
<meta charset="utf-8">
</head>
<body>
<?php

require_once("EMT.php");

function is_json($string) {
    return ((is_string($string) && (is_object(json_decode($string)) || is_array(json_decode($string))))) ? true : false;
}

$err = array();

if(empty($_POST['title-article']) or empty($_POST['author-article']) or 
			empty($_POST['origin-article']) or empty($_POST['md-content'])){
  $err[] = "Обязательные поля не заполнены!";
}

if (!is_json("{".$_POST['json-optional']."}")){
  $err[] = "Ошибка в дополнительных данных";
}

if(count($err) == 0){

  $unic_string = uniqid();

  $json_filename = "./temp/{$unic_string}.json";
  $md_filename = "./temp/{$unic_string}.md";
  
  $json_file = fopen($json_filename,'w');
  $md_file = fopen($md_filename, 'w');

/*
  $json_file = fopen("1.json",'w');
  $md_file = fopen("1.md", 'w');
*/

  $json_data = '{
  "title-article" : "'.addslashes($_POST['title-article']).'",
  "author-article" : "'.addslashes($_POST['author-article']).'",
  "origin-article": "'.addslashes($_POST['origin-article']).'",
  '.$_POST['json-optional'].'
}';

  if (fwrite($json_file, $json_data)){
    echo 'Данные в json-файл успешно занесены.<br>';
    echo '<a href="'.$json_filename.'" download>Скачать json</a>';
  } else 
    echo 'Ошибка при записи в json-файл.';

  fclose($json_file); 
  
//  $md_data = mb_convert_encoding($_POST['md-content'], 'utf-8', mb_detect_encoding($_POST['md-content']));

  $md_data = $_POST['md-content'];
   

  $typograf = new EMTypograph();
  $options = array(
      'Text.paragraphs'=>'off',
      'Text.breakline'=>'off',    
      'Text.auto_links' => 'off',
      'Text.email' => 'off',
  );

  $typograf->setup($options); 

  $typograf->set_text($md_data);
  $md_data_typ = $typograf->apply();
   
//  print_r($typograf->get_options_list());
//  print_r($typograf->get_option_info());  
  if (fwrite($md_file, $md_data_typ)){ 
    echo '<br>Данные в md-файл успешно занесены.<br>';
    echo '<a href="'.$md_filename.'" download>Скачать md</a>';
  } else 
    echo 'Ошибка при записи в md-файл.';
  
  fclose($md_file); 
} else {
  foreach($err as $error) {
		echo "$error <br>";
  }
}
?>
<br><a href="/marx/">На главную</a>
</body>
</html>