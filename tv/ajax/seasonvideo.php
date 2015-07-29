<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET ['i'] && $_GET ['s']) {
	$Trailer = $tmdb->getTvSeasonVideos ( $_GET ['i'], $_GET ['s'] );
	echo '<div class="embed-responsive embed-responsive-16by9">
		<iframe class="embed-responsive-item" 
			src="http://www.youtube.com/v/' . $Trailer ['results'] [0] ['key'] . '?autoplay=1"  frameborder="0" allowfullscreen />
		</div>';
}
?>