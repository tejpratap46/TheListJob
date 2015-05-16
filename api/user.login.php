<?php
require 'api.key.php';

$email = $_GET['email'];
$password = $_GET['password'];

if ($email && $password) {
	$query = mysql_query("SELECT * FROM user WHERE email='".$email."' AND password='".$password."'") or die('{"status":0,"error":"'.mysql_error().'"}');
	if (mysql_num_rows($query) == 1) {
		echo "{";
		echo '"status":1,';
		echo '"email":"'.$email.'"';
		echo "}";
	}else{
		die('{"status":0,"error":"Invalid email Or password"}');
	}
}else{
	die('{"status":0,"error":"'.mysql_error().'"}');
}
?>