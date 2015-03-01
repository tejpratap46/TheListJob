<?php
error_reporting ( 0 );
include '../../TMDb.php';

$title = array (
		"Top Rated",
		"Popular",
		"Up Coming",
		"Now Playing",
		"IMDB Top 250",
		"Discover"
);
$url = array (
		"toprated",
		"popular",
		"upcoming",
		"nowplaying",
		"imdb250",
		"discover" 
);

for($i = 0; $i < count ( $title ); $i ++) {
	echo '<div class="col-sm-6 col-md-4">
					<a href="lists.php?t=' . $url [$i] . '"><div class="thumbnail">
						<div class="caption">
							<h2 class="center ellipsis">' . $title [$i] . '</h2>
						</div>
					</div></a>
				</div>';
}

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
$config = $tmdb->getConfig ();
$Genres = $tmdb->getGenres ();
// echo json_encode($Genres);

for($i = 0; $i < count ( $Genres['genres'] ); $i ++) {
	echo '<div class="col-sm-6 col-md-4">
					<a href="genre.php?t=' . $Genres ['genres'][$i]['id'] . '"><div class="thumbnail">
						<div class="caption">
							<h2 class="center ellipsis">' . $Genres ['genres'][$i]['name'] . '</h2>
						</div>
					</div></a>
				</div>';
}
?>