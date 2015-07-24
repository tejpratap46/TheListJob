<?php
// error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig (); 
if ($_GET ['i']) {
	$Images = $tmdb->getMovieImages ( $_GET ['i'] );
	// echo json_encode($Images);
	echo '<h2 class="bold">Movies Backdrops</h2>';
	for($i = 0; $i < count ( $Images ['backdrops'] ); $i ++) {
		echo '<div class="jumbotron no-padding" style="padding-left: 0px; padding-right: 0px; overflow: hidden;">
		<img class="center-image full-width" src="http://image.tmdb.org/t/p/w780' . $Images ['backdrops'] [$i] ['file_path'] . '" alt="' . $i . '">
		</div>';
	}
}
?>