<?php
require 'api.key.php';

$email = $_GET['email'];
$name = $_GET['name'];
$rss = $_GET['rss'];

if ($email && $name && $rss) {
	$query = mysql_query("INSERT INTO `". md5($email) ."`(`podcastTodo`) VALUES ('<name>".$name."</name><rss>".$rss."</rss>')") or die('{"status":0,"error":"'.mysql_error().'"}');
	if ($query) {
		echo "{";
		echo '"status":1,';
		echo '"email":"'.$email.'",';
		echo '"name":"'.$name.'",';
		echo '"rss":"'.$rss.'"';
		echo "}";
	}else{
		die('{"status":0,"error":"Email already used"}');
	}
}else{
	die('{"status":0,"error":"'.mysql_error().'"}');
}
?>