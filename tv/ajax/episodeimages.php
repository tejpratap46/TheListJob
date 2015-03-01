<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
$config = $tmdb->getConfig ();
if ($_GET ['i'] && $_GET ['s'] && $_GET ['e']) {
	$Images = $tmdb->getTvEpisodeImages ( $_GET ['i'], $_GET ['s'], $_GET ['e'] );
	for($i = 0; $i < count ( $Images ['stills'] ); $i ++) {
		echo '<div class="jumbotron no-padding" style="padding-left: 0px; padding-right: 0px; overflow: hidden;">
		<img class="center-image full-width" src="http://image.tmdb.org/t/p/w780' . $Images ['stills'] [$i] ['file_path'] . '" alt="' . $i . '">
		</div>';
	}
}
?>