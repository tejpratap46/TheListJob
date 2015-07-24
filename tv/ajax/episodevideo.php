<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET ['i'] && $_GET ['s'] && $_GET ['e']) {
	$Trailer = $tmdb->getTvEpisodeVideos ( $_GET ['i'], $_GET ['s'], $_GET ['e'] );
	for($i = 0; $i < count ( $Trailer ['results'] ); $i ++) {
		echo '<div class="jumbotron no-padding" style="padding-left: 0px; padding-right: 0px; overflow: hidden;">
		<embed style="width:100%; height:500px;"
			src="http://www.youtube.com/v/' . $Trailer ['results'] [$i] ['key'] . '" />
		</div>';
	}
}
?>