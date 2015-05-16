<?php
require 'api.key.php';

$email = $_GET['email'];
$password = $_GET['password'];

if ($email && $password) {
	$query = mysql_query("INSERT INTO `user`(`email`, `password`) VALUES ('$email', '$password')") or die('{"status":0,"error":"'.mysql_error().'"}');
	if ($query) {
		echo "{";
		echo '"status":1,';
		echo '"email":"'.$email.'"';
		echo "}";
	}else{
		die('{"status":0,"error":"Email already used"}');
	}
}else{
	die('{"status":0,"error":"'.mysql_error().'"}');
}
?>