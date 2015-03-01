<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
$config = $tmdb->getConfig ();
if ($_GET ['p'])
	$Movies = $tmdb->getSimilarMovies ( $_GET ['p'] );
else
	$Movies = $tmdb->getMovie ('tt0111161');
	echo json_encode ( $Movies );
?>