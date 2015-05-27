<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
$config = $tmdb->getConfig ();
if ($_GET ['i']) {
	$Movie = $tmdb->getTv ( $_GET ['i'] );
	echo '<div class="thumbnail center">
			<div class="row">
				<div class="col-md-12">
					<h1 class="center bold">' . $Movie ['name'] . '</h1>
				</div>
			</div>
		</div>
		<div class="jumbotron no-padding" style="padding-left: 0px; padding-right: 0px; overflow: hidden;">
			<img class="center-image full-width" alt="' . $Movie ['name'] . '"
					src="http://image.tmdb.org/t/p/w780' . $Movie ['backdrop_path'] . '">
		</div>
		<div class="thumbnail no-padding" style="padding-left: 0px; padding-right: 0px;">
			<div class="row">
				<div class="col-md-2">
				<img class="center-image full-width" alt="loading..."
						src="http://image.tmdb.org/t/p/w185' . $Movie ['poster_path'] . '">
				</div>
				<div class="col-md-3 center">
				<h1 style="font-size: 10em;"><strong>' . $Movie ['vote_average'] . '</strong></h1><br />
				<h4>By - ' . $Movie ['vote_count'] . ' voters</h4>
				<p>"' . $Movie ['first_air_date'] . '" - "' . $Movie ['last_air_date'] . '"</p>
				</div>
				<div class="col-md-7 center">
					<h1 class="center-vertical ellipsis bold" style="font-size: 7em;">' . $Movie ['name'] . '</h1><br />
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<button type="button" id="add" class="btn btn-lg btn-success full-width bottom" onclick=\'addToList("' . str_replace("'","",$Movie ['name']) . '","' . $Movie ['id'] . '")\'>Add To TO-DO</button>
				<button type="button" id="remove" class="btn btn-lg btn-danger full-width bottom" onclick=\'removeFromTodo("' . $Movie ['id'] . '")\' style="display: none;">Remove From TO-DO</button>
			</div>
			<div class="col-md-6">
				<button type="button" class="btn btn-lg btn-primary full-width bottom" onclick="getTrailer()">Trailer</button>
			</div>
		</div>

		<div id="trailer"></div>
		<div class="jumbotron no-padding">
			<div class="row">
				<div class="col-md-12">
					<h1 class="center-vertical bold">Plot</h1><br />
					<p>' . $Movie ['overview'] . '</p>
				</div>
			</div>
		</div>
		<div class="jumbotron no-padding">
			<h1 class="bold">Seasons<h1>';
	getSeasons ( $Movie );
	echo '</div>
		<div class="jumbotron no-padding">
			<div class="row">
				<div class="col-md-3">
					<h1 class="center-vertical ellipsis bold">Genre</h1><br />';
	getGenre ( $Movie );
	echo '</div>
				<div class="col-md-3">
				<h1 class="center-vertical ellipsis bold">Production</h1><br />';
	getProduction ( $Movie );
	echo '</div>
				<div class="col-md-3">
				<h1 class="center-vertical ellipsis bold">On & In</h1><br />';
	getNetwork ( $Movie );
	echo '</div>
				<div class="col-md-3">
				<h1 class="center-vertical ellipsis bold">Extra</h1><br />';
	getExtra ( $Movie );
	echo '</div>
			</div>
		</div>';
}
function getGenre($Movie) {
	for($i = 0; $i < count ( $Movie ['genres'] ); $i ++) {
		echo '<h4 class="no-padding no-margin">' . ($i + 1) . ". " . $Movie ['genres'] [$i] ['name'] . '</h4><br />';
	}
}
function getProduction($Movie) {
	for($i = 0; $i < count ( $Movie ['production_companies'] ); $i ++) {
		echo '<h4 class="no-padding no-margin">' . ($i + 1) . ". " . $Movie ['production_companies'] [$i] ['name'] . '</h4><br />';
	}
}
function getNetwork($Movie) {
	echo "<h3>On</h3>";
	for($i = 0; $i < count ( $Movie ['networks'] ); $i ++) {
		echo '<h4 class="no-padding no-margin">' . ($i + 1) . ". " . $Movie ['networks'] [$i] ['name'] . '</h4><br />';
	}
	echo "<h3>In</h3>";
	for($i = 0; $i < count ( $Movie ['origin_country'] ); $i ++) {
		echo '<h4 class="no-padding no-margin">' . ($i + 1) . ". " . $Movie ['origin_country'] [$i] . '</h4><br />';
	}
}
function getSeasons($Movie) {
	$numSea = count ( $Movie ['seasons'] );
	for($i = 0; $i < $numSea; $i ++) {
		if ($i % 6 == 0) {
			echo '<div class="row">';
		}
		echo '<div class="col-sm-6 col-md-2">
					<a href="season.php?i=' . $Movie ['id'] . '&s=' . $Movie ['seasons'] [$i] ['season_number'] . '"><div class="thumbnail">
						<img style="width: 100%;" src="http://image.tmdb.org/t/p/w185' . $Movie ['seasons'] [$i] ['poster_path'] . '" alt="' . $Movies ['seasons'] [$i] ['season_number'] . '">
						<div class="caption">
							<h2 class="center ellipsis">Season : ' . $Movie ['seasons'] [$i] ['season_number'] . '</h2>
							<p class="center ellipsis">Episodes : ' . $Movie ['seasons'] [$i] ['episode_count'] . '</p>
						</div>
					</div></a>
				</div>';
		if ($i % 6 == 5) {
			echo '</div>';
		} elseif ($i == $numSea - 1) {
			echo '</div>';
		}
	}
}
function getExtra($Movie) {
	echo '<p class="no-padding no-margin">' . $Movie ['episode_run_time'] [0] . ' min</p>';
	echo '<p class="no-padding no-margin">' . $Movie ['status'] . ' min</p>';
	echo '<p class="no-padding no-margin">' . $Movie ['type'] . ' min</p>';
	echo '<a href ="' . $Movie ['homepage'] . '"><h3>Website</h3></a>';
}
?>
