 <?php
require '../api.key.php';
require 'music.pagination.php';
$email = $_GET['email'];

if ($email) {
	$table = md5($email);
	$query = mysql_query("SELECT musicTodo FROM $table WHERE musicTodo IS NOT NULL LIMIT $start,$limit")  or die('{"status":0,"error":"'.mysql_error().'"}');
	if ($query) {
		$num = mysql_num_rows($query);
		echo "{";
		echo '"status":1,';
		echo '"total":"'.$total.'",';
		echo '"music":[';
		for ($i=0; $i < $num; $i++) {
			$info = mysql_fetch_array($query);
			if ($i < $num-1) {
				echo '"'.$info['musicTodo'].'",';
			}else{
				echo '"'.$info['musicTodo'].'"';
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
