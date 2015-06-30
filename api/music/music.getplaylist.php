 <?php
require '../api.key.php';
$email = $_GET['email'];

if ($email) {
	$table = md5($email);
	$query = mysql_query("SELECT musicPlaylist FROM $table WHERE musicPlaylist IS NOT NULL")  or die('{"status":0,"error":"'.mysql_error().'"}');
	if ($query) {
		$num = mysql_num_rows($query);
		echo "{";
		echo '"status":1,';
		echo '"music":[';
		for ($i=0; $i < $num; $i++) {
			$info = mysql_fetch_array($query);
			if ($i < $num-1) {
				echo '"'.$info['musicPlaylist'].'",';
			}else{
				echo '"'.$info['musicPlaylist'].'"';
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
