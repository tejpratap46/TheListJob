<?php
require '../api.key.php';

$email = $_GET['email'];
$id = $_GET['id'];

if ($email && $id) {
	$queryCheck = mysql_query("SELECT id FROM `". md5($email) ."` WHERE `movieTodo` LIKE '%" . $id . "%'") or die('{"status":0,"error":"'.mysql_error().'"}');
	if (mysql_num_rows($queryCheck) == 0) {
		die('{"status":0,"error":"Already Removed From Your Watchlist"}');
	}

	$qArray = mysql_fetch_array($queryCheck);
	$id = $qArray['id'];

	$query = mysql_query("UPDATE `". md5($email) ."` SET `movieTodo`=NULL WHERE id='" . $id . "'") or die('{"status":0,"error":"'.mysql_error().'"}');
	if ($query) {
		echo "{";
		echo '"status":1,';
		echo '"email":"'.$email.'",';
		echo '"id":"'.$id.'",';
		echo '"id":"'.$id.'"';
		echo "}";
	}else{
		die('{"status":0,"error":"Cannot Remove"}');
	}
}else{
	die('{"status":0,"error":"'.mysql_error().'"}');
}
?>
