<?php
$page = $_GET ['page'];
$limit = $_GET ['limit'];

// if limit not set
if (! $limit) {
	$limit = 10;
}

if ($_GET['email']) {
	$email = md5($_GET['email']);
	$query = "SELECT COUNT(*) as num FROM $email WHERE musicTodo IS NOT NULL";

	$total_pages = mysql_fetch_array ( mysql_query ( $query ) );
	$total = $total_pages ['num'];
	$total_pages = $total_pages ['num'];
	$total_pages = $total_pages / $limit;
	$total_pages = ceil ( $total_pages );

	// pagination
	if ($page) {
		if ($page < 2) {
			$start = 0;
		} else if ($page > $total_pages) {
			// $start = $total_pages;
			die();
		} else {
			$start = ($page - 1) * $limit;
		}
	} else {
		$page = 1;
		$start = 0;
	}
}else{
	die('{"status:0","error":"email not given in pagination"}');
}

?>
