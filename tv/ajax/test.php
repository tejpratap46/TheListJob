<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET ['i']) {
	$Movie = $tmdb->getTv ( $_GET ['i'] );
	echo json_encode($Movie);
}else{
	echo "enter id";
}
?>
