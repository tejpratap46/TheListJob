<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET ['i']) {
	$Movie = $tmdb->getPerson ( $_GET ['i'] );
	echo '<div class="thumbnail center">
			<div class="row">
				<div class="col-md-12">
					<h1 class="center bold">' . $Movie ['name'] . '</h1>
				</div>
			</div>
		</div>
		<div class="thumbnail no-padding" style="padding-left: 0px; padding-right: 0px;">
			<div class="row">
				<div class="col-md-2">
				<img class="center-image full-width" alt="loading..."
						src="http://image.tmdb.org/t/p/w185' . $Movie ['profile_path'] . '">
				</div>
				<div class="col-md-3 center">
					<a style="font-size: 2em;" class="bold" href="' . $Movie ['homepage'] . '">Homepage</a>
					<h4>Died - ' . $Movie ['deathday'] . '</h4>
					<h3>Born - ' . $Movie ['birthday'] . '</h3>
				</div>
				<div class="col-md-7 center">
					<h1 class="center-vertical ellipsis bold" style="font-size: 7em;">' . $Movie ['name'] . '</h1>
					<a target="_blank" href="http://www.imdb.com/name/' . $Movie ['imdb_id'] . '" class="btn btn-warning">IMDB</a><br />
				</div>
			</div>
			<div class="well">
				<p class="center-vertical">"' . $Movie ['biography'] . '"</p>
			</div>
		</div>';
}
?>
