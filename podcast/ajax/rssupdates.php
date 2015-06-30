<?php 
error_reporting(0);
if ($_GET['rss']) {
	echo file_get_contents('http://ajax.googleapis.com/ajax/services/feed/load?v=2.0&q='.$_GET['rss'].'&num=1');
}else{
	die('{"status":0,"error":"Enter rss"}');
}
?>