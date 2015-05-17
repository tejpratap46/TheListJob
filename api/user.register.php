<?php
require 'api.key.php';

$email = $_GET['email'];
$password = $_GET['password'];

if ($email && $password) {
	$query = mysql_query("INSERT INTO `user`(`email`, `password`) VALUES ('$email', '$password')") or die('{"status":0,"error":"'.mysql_error().'"}');
	if ($query) {

		// think on this
		$tableName = md5($email);
		$queryNewTable = mysql_query("CREATE TABLE $tableName
										(
											movieTodo TEXT,
											tvTodo TEXT,
											podcastTodo TEXT
										)") or die('{"status":0,"error":"'.mysql_error().'"}');
		if ($queryNewTable) {
			echo "{";
			echo '"status":1,';
			echo '"email":"'.$email.'"';
			echo "}";
		}
	}else{
		die('{"status":0,"error":"Email already used"}');
	}
}else{
	die('{"status":0,"error":"'.mysql_error().'"}');
}
?>