<?php
require '../api.key.php';

$email = $_GET['email'];
$name = $_GET['name'];
$rss = $_GET['rss'];

if ($email && $name && $rss) {
	$email = md5($email);
	$queryCheck = mysql_query("SELECT id FROM `". $email ."` WHERE `podcastTodo` LIKE '%" . $name . "%'") or die('{"status":0,"error":"'.mysql_error().'"}');
	if (mysql_num_rows($queryCheck) > 0) {
		die('{"status":0,"error":"You Already Subscribed"}');
	}

	$queryNull = mysql_query("SELECT id FROM `". $email ."` WHERE `podcastTodo` IS NULL") or die('{"status":0,"error":"'.mysql_error().'"}');
	$query = NULL;
	if (mysql_num_rows($queryNull) > 0) {
		$qArray = mysql_fetch_array($queryNull);
		$id = $qArray['id'];
		$query = mysql_query("UPDATE `". $email ."` SET `podcastTodo`='<name>".$name."</name><rss>".$rss."</rss>' WHERE id='" . $id . "'") or die('{"status":0,"error":"'.mysql_error().'"}');
	}else{
		$query = mysql_query("INSERT INTO `". $email ."`(`podcastTodo`) VALUES ('<name>".$name."</name><rss>".$rss."</rss>')") or die('{"status":0,"error":"'.mysql_error().'"}');
	}

	if ($query != NULL) {
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
	die('{"status":0,"error":"Enter email,id,name"}');
}
?>
