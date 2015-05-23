<?php
require '../api.key.php';

$email = $_GET['email'];
$password = $_GET['password'];

if ($email && $password) {
	// think on this
	$tableName = md5($email);
	$queryNewTable = mysql_query("CREATE TABLE $tableName
									(
										id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
										movieTodo VARCHAR(10000) DEFAULT 'EMPTY',
										tvTodo VARCHAR(10000) DEFAULT 'EMPTY',
										podcastTodo VARCHAR(10000) DEFAULT 'EMPTY',
										musicPlaylist VARCHAR(10000) DEFAULT 'EMPTY',
										podcastPlaylist VARCHAR(10000) DEFAULT 'EMPTY',
										dummy1 VARCHAR(10000) DEFAULT 'EMPTY',
										dummy2 VARCHAR(10000) DEFAULT 'EMPTY'
									)") or die('{"status":0,"error":"'.mysql_error().'"}');
	if ($queryNewTable) {
	$query = mysql_query("INSERT INTO `user`(`email`, `password`) VALUES ('$email', '$password')") or die('{"status":0,"error":"'.mysql_error().'"}');
		if ($query) {
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