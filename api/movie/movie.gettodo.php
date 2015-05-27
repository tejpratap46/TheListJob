 <?php
require '../api.key.php';
require 'movie.pagination.php';
$email = $_GET['email'];

if ($email) {
	$table = md5($email);
	$query = mysql_query("SELECT movieTodo FROM $table WHERE movieTodo IS NOT NULL LIMIT $start,$limit")  or die('{"status":0,"error":"'.mysql_error().'"}');
	if ($query) {
		$num = mysql_num_rows($query);
		echo "{";
		echo '"status":1,';
		echo '"total":"'.$total.'",';
		echo '"movies":[';
		for ($i=0; $i < $num; $i++) {
			$info = mysql_fetch_array($query);
			if ($i < $num-1) {
				echo '"'.$info['movieTodo'].'",';
			}else{
				echo '"'.$info['movieTodo'].'"';
			}
		}
		echo "]}";
	}else{
		die('{"status":0,"error":"Cannot Add"}');
	}
}else{
	die('{"status":0,"error":"'.mysql_error().'"}');
}
?>
