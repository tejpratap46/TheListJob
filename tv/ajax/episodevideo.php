<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET ['i'] && $_GET ['s'] && $_GET ['e']) {
	$Trailer = $tmdb->getTvEpisodeVideos ( $_GET ['i'], $_GET ['s'], $_GET ['e'] );
	for($i = 0; $i < count ( $Trailer ['results'] ); $i ++) {
		echo '<div class="embed-responsive embed-responsive-16by9">
		<iframe class="embed-responsive-item" 
			src="http://www.youtube.com/v/' . $Trailer ['results'] [$i] ['key'] . '"  frameborder="0" allowfullscreen />
		</div>';
	}
}
?>