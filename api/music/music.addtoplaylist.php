<?php
require '../api.key.php';

$email = $_GET['email'];
$name = $_GET['name'];
$url = $_GET['url'];

if ($email && $name && $url) {
	$email = md5($email);
	$queryCheck = mysql_query("SELECT id FROM `". $email ."` WHERE `musicPlaylist` LIKE '%" . $name . "%'") or die('{"status":0,"error":"'.mysql_error().'"}');
	if (mysql_num_rows($queryCheck) > 0) {
		die('{"status":0,"error":"You Already Added"}');
	}

	$queryNull = mysql_query("SELECT id FROM `". $email ."` WHERE `musicPlaylist` IS NULL") or die('{"status":0,"error":"'.mysql_error().'"}');
	$query = NULL;
	if (mysql_num_rows($queryNull) > 0) {
		$qArray = mysql_fetch_array($queryNull);
		$id = $qArray['id'];
		$query = mysql_query("UPDATE `". $email ."` SET `musicPlaylist`='<name>".$name."</name><url>".$url."</url>' WHERE id='" . $id . "'") or die('{"status":0,"error":"'.mysql_error().'"}');
	}else{
		$query = mysql_query("INSERT INTO `". $email ."`(`musicPlaylist`) VALUES ('<name>".$name."</name><url>".$url."</url>')") or die('{"status":0,"error":"'.mysql_error().'"}');
	}

	if ($query) {
		echo "{";
		echo '"status":1,';
		echo '"email":"'.$email.'",';
		echo '"name":"'.$name.'",';
		echo '"url":"'.$url.'"';
		echo "}";
	}else{
		die('{"status":0,"error":"Cannot Add"}');
	}
}else{
	die('{"status":0,"error":"'.mysql_error().'"}');
}
?>
