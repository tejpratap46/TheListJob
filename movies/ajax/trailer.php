<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET ['i']) {
	$Trailer = $tmdb->getMovieTrailers ( $_GET ['i'] );
	echo '<div class="embed-responsive embed-responsive-16by9">
		<iframe class="embed-responsive-item" 
			src="http://www.youtube.com/embed/' . $Trailer ['youtube'] [0] ['source'] . '?autoplay=1" frameborder="0" allowfullscreen />
		</div>';
}
?>