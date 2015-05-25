<?php
require '../api.key.php';

$email = $_GET['email'];
$name = $_GET['name'];
$rss = $_GET['rss'];

if ($email && $name && $rss) {
	$queryCheck = mysql_query("SELECT id FROM `". md5($email) ."` WHERE `podcastTodo` LIKE '%" . $name . "%' OR `podcastTodo` LIKE '%" . $rss . "%'") or die('{"status":0,"error":"'.mysql_error().'"}');
	if (mysql_num_rows($queryCheck) == 0) {
		die('{"status":0,"error":"You Already Subscribed"}');
	}

	$qArray = mysql_fetch_array($queryCheck);
	$id = $qArray['id'];

	$query = mysql_query("UPDATE `". md5($email) ."` SET `podcastTodo`=NULL WHERE id='" . $id . "'") or die('{"status":0,"error":"'.mysql_error().'"}');
	if ($query) {
		echo "{";
		echo '"status":1,';
		echo '"email":"'.$email.'",';
		echo '"name":"'.$name.'",';
		echo '"rss":"'.$rss.'"';
		echo "}";
	}else{
		die('{"status":0,"error":"Cannot Subscribe"}');
	}
}else{
	die('{"status":0,"error":"'.mysql_error().'"}');
}
?>