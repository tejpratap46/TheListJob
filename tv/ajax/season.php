<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET ['i'] && $_GET ['s']) {
	$Movie = $tmdb->getTvSeason ( $_GET ['i'], $_GET ['s'] );
	echo '<div class="jumbotron no-padding" style="padding-left: 0px; padding-right: 0px; overflow: hidden;">
			<div class="row">
				<div class="col-md-2">
				<img class="center-image full-width" alt="' . $Movie ['name'] . '"
						src="http://image.tmdb.org/t/p/w185' . $Movie ['poster_path'] . '">
				</div>
				<div class="col-md-10 center">
					<h1 class="ellipsis">' . $Movie ['name'] . '</h1>
					<button type="button" class="btn btn-lg btn-primary full-width" onclick="getTrailer()">Trailer</button>
				</div>
			</div>
		</div>
		<div id="trailer"></div>
		<div class="jumbotron no-padding">
			<div class="row">
				<div class="col-md-12">
					<h1 class="center-vertical">Plot</h1><br />
					<p>' . $Movie ['overview'] . '</p>
				</div>
			</div>
		</div>';
	showEpisodes($Movie);
}
function showEpisodes($Movie) {
	for($i = 0; $i < count ( $Movie ['episodes'] ); $i ++) {
		echo '<a href="episode.php?i='.$_GET['i'].'&s=' . $Movie ['episodes'] [$i] ['season_number'] . '&e=' . $Movie ['episodes'] [$i] ['episode_number'] . '">
				<div class="jumbotron no-padding" style="padding-left: 0px; padding-right: 0px; overflow: hidden;">
					<div class="row">
						<div class="col-md-4">
						<img class="center-image full-width full-height" alt="' . $Movie ['episodes'] [$i] ['name'] . '"
								src="http://image.tmdb.org/t/p/w185' . $Movie ['episodes'] [$i] ['still_path'] . '">
						</div>
						<div class="col-md-8">
							<h1 class="ellipsis">' . $Movie ['episodes'] [$i] ['name'] . ' (S' . $Movie ['episodes'] [$i] ['season_number'] . ' E' . $Movie ['episodes'] [$i] ['episode_number'] . ')</h1>
							<p>' . $Movie ['episodes'] [$i] ['overview'] . '</p>
						</div>
					</div>
				</div>
			</a>';
	}
}
?>