<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET ['i']) {
	$Movie = $tmdb->getMovie ( $_GET ['i'] );
	echo '<div class="thumbnail center">
			<div class="row">
				<div class="col-md-12">
					<h1 class="center bold">' . $Movie ['title'] . '</h1>
				</div>
			</div>
		</div>
		<div class="jumbotron no-padding" style="padding-left: 0px; padding-right: 0px; overflow: hidden;">
		<img class="center-image full-width" alt="' . $Movie ['title'] . '"
					src="http://image.tmdb.org/t/p/w780' . $Movie ['backdrop_path'] . '">
		</div>
		<div class="thumbnail no-padding" style="padding-left: 0px; padding-right: 0px;">
			<div class="row">
				<div class="col-md-2">
				<img class="center-image full-width" alt="loading..."
						src="http://image.tmdb.org/t/p/w185' . $Movie ['poster_path'] . '">
				</div>
				<div class="col-md-3 center">
					<h1 style="font-size: 10em;" class="bold">' . $Movie ['vote_average'] . '</h1>
					<h4>By - ' . $Movie ['vote_count'] . ' voters</h4>
					<h3>' . $Movie ['release_date'] . '</h3>
				</div>
				<div class="col-md-7 center">
					<h1 class="center-vertical ellipsis bold" style="font-size: 7em;">' . $Movie ['original_title'] . '</h1>
					<p class="center-vertical">"' . $Movie ['tagline'] . '"</p>
					<a target="_blank" href="http://www.imdb.com/title/' . $Movie ['imdb_id'] . '" class="btn btn-warning">IMDB</a><br />
					<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http://brainstrom.zz.mu/TheListJob/movies/movie.php?i='.$_GET['i'].'">share to facebook</a>
				</div>
			</div>
		</div>
		<div class="row well">
			<div class="col-md-6">
				<button type="button" id="add" class="btn btn-lg btn-success full-width" onclick="addToList(\'' . str_replace("'","",$Movie ['original_title']) . '\',\'' . $Movie ['id'] . '\',\'' . $Movie ['imdb_id'] . '\',\'' . $Movie ['backdrop_path'] . '\')">Add To TO-DO</button>
				<button type="button" id="remove" class="btn btn-lg btn-danger full-width" onclick="removeFromTodo(\'' . $Movie ['imdb_id'] . '\')" style="display: none;">Remove From TO-DO</button>
			</div>
			<div class="col-md-6">
				<button type="button" class="btn btn-lg btn-primary full-width" onclick="getTrailer()">Trailer</button>
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
		<div class="thumbnail">
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
					<h1 class="center-vertical ellipsis bold">Countries</h1><br />';
					getCountries ( $Movie );
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
	echo '<h3>Spent : $' . $Movie ['budget'] . '</h3>';
	echo '<h3>Revenue : $' . $Movie ['revenue'] . '</h3>';
	echo '<a href ="' . $Movie ['homepage'] . '"><h3 class="bold">Website</h3></a>';
}
?>
