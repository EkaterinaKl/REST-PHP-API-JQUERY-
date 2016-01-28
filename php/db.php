<?php 




$db_host = '127.0.0.1';
$db_login = 'root';
$db_pass = '';
$db_name = 'katalog';

//j,hf,jnfnm jib,re gjlrk.xtybz +POSTGRE SQL
//API : http://habrahabr.ru/post/143317/
try { 
$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_login, $db_pass,  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}  
catch(PDOException $e) {  
    $obj = (object) array('result' => false,'error' => "Ошибка подключения базы данных" );
	echo json_encode($obj); 
	exit;
    
}
?>
