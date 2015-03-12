<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
$config = $tmdb->getConfig ();
if ($_GET ['i']) {
	$Movie = $tmdb->getMovie ( $_GET ['i'] );
	echo '<div class="jumbotron no-padding">
			<div class="row">
				<div class="col-md-12">
					<h1 class="center-vertical">' . $Movie ['title'] . '</h1>
				</div>
			</div>
		</div>
		<div class="jumbotron no-padding" style="padding-left: 0px; padding-right: 0px; overflow: hidden;">
		<img class="center-image full-width" alt="' . $Movie ['title'] . '"
					src="http://image.tmdb.org/t/p/w780' . $Movie ['backdrop_path'] . '">
		</div>
		<div class="jumbotron no-padding" style="padding-left: 0px; padding-right: 0px;">
			<div class="row">
				<div class="col-md-2">
				<img class="center-image full-width" alt="loading..."
						src="http://image.tmdb.org/t/p/w185' . $Movie ['poster_path'] . '">
				</div>
				<div class="col-md-3 center">
				<h1 style="font-size: 10em;"><strong>' . $Movie ['vote_average'] . '</strong></h1><br />
				<h4>By - ' . $Movie ['vote_count'] . ' voters</h4>
				<h3>Release : ' . $Movie ['release_date'] . '</h3>
				</div>
				<div class="col-md-7 center">
					<h1 class="center-vertical ellipsis" style="font-size: 7em;">' . $Movie ['original_title'] . '</h1><br />
					<h3 class="center-vertical"><i>"' . $Movie ['tagline'] . '"</i></h3><br />
							<div class="row">
							<div class="col-md-6">
					<button type="button" class="btn btn-lg btn-success full-width bottom" onclick="addToList(\'' . $Movie ['imdb_id'] . '\')">Add To List</button>
							</div>
							<div class="col-md-6">
					<button type="button" class="btn btn-lg btn-primary full-width bottom" onclick="getTrailer()">Trailer</button>
							</div>
							</div>
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
		</div>
		<div class="jumbotron no-padding">
			<div class="row">
				<div class="col-md-3">
					<h1 class="center-vertical ellipsis">Genre</h1><br />';
	getGenre ( $Movie );
	echo '</div>
				<div class="col-md-3">
				<h1 class="center-vertical ellipsis">Production</h1><br />';
	getProduction ( $Movie );
	echo '</div>
				<div class="col-md-3">
				<h1 class="center-vertical ellipsis">Countries</h1><br />';
	getCountries ( $Movie );
	echo '</div>
				<div class="col-md-3">
				<h1 class="center-vertical ellipsis">Extra</h1><br />';
	getExtra ( $Movie );
	echo '</div>
			</div>
		</div>';
}
function getGenre($Movie) {
	for($i = 0; $i < count ( $Movie ['genres'] ); $i ++) {
		echo '<a href="genre.php?t=' . $Movie ['genres'] [$i] ['id'] . '"><h4 class="no-padding no-margin">' . ($i + 1) . ". " . $Movie ['genres'] [$i] ['name'] . '</h4></a><br />';
	}
}
function getProduction($Movie) {
	for($i = 0; $i < count ( $Movie ['production_companies'] ); $i ++) {
		echo '<h4 class="no-padding no-margin">' . ($i + 1) . ". " . $Movie ['production_companies'] [$i] ['name'] . '</h4><br />';
	}
}
function getCountries($Movie) {
	for($i = 0; $i < count ( $Movie ['production_countries'] ); $i ++) {
		echo '<h4 class="no-padding no-margin">' . ($i + 1) . ". " . $Movie ['production_countries'] [$i] ['name'] . '</h4><br />';
	}
}
function getExtra($Movie) {
	echo '<h3>' . $Movie ['runtime'] . 'min</h3>';
	echo '<h3>' . $Movie ['budget'] . '$ spent</h3>';
	echo '<h3>' . $Movie ['revenue'] . '$ revenue</h3>';
	echo '<a href ="' . $Movie ['homepage'] . '"><h3>Website</h3></a>';
}
?>