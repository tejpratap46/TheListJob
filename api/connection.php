<?php
$user = "root";
$password = "";
$database = "thelistjob";
$hostname = "localhost";

/*
$user = "u799949332_tlj";
$password = "9860637720";
$database = "u799949332_tlj";
$hostname = "mysql.hostinger.in";
*/

mysql_connect ( $hostname, $user, $password );
@mysql_select_db ( $database ) or die ( "Unable to select database" );
?>
