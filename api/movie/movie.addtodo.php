<?php
require '../api.key.php';

$email = $_GET['email'];
$name = $_GET['name'];
$id = $_GET['id'];

if ($email && $name && $id) {
	$queryCheck = mysql_query("SELECT id FROM `". md5($email) ."` WHERE `movieTodo` LIKE '%" . $name . "%'") or die('{"status":0,"error":"'.mysql_error().'"}');
	if (mysql_num_rows($queryCheck) > 0) {
		die('{"status":0,"error":"You Already Added"}');
	}

	$queryNull = mysql_query("SELECT id FROM `". md5($email) ."` WHERE `movieTodo` = 'EMPTY'") or die('{"status":0,"error":"'.mysql_error().'"}');
	$query = NULL;
	if (mysql_num_rows($queryNull) > 0) {
		$qArray = mysql_fetch_array($queryNull);
		$id = $qArray['id'];
		$query = mysql_query("UPDATE `". md5($email) ."` SET `movieTodo`='<name>".$name."</name><id>".$id."</id>' WHERE id='" . $id . "'") or die('{"status":0,"error":"'.mysql_error().'"}');
	}else{
		$query = mysql_query("INSERT INTO `". md5($email) ."`(`movieTodo`) VALUES ('<name>".$name."</name><id>".$id."</id>')") or die('{"status":0,"error":"'.mysql_error().'"}');
	}

	if ($query) {
		echo "{";
		echo '"status":1,';
		echo '"email":"'.$email.'",';
		echo '"name":"'.$name.'",';
		echo '"id":"'.$id.'"';
		echo "}";
	}else{
		die('{"status":0,"error":"Cannot Add"}');
	}
}else{
	die('{"status":0,"error":"'.mysql_error().'"}');
}
?>