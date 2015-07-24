<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET ['i'] && $_GET ['s'] && $_GET ['e']) {
	$Movie = $tmdb->getTvEpisode ( $_GET ['i'], $_GET ['s'], $_GET ['e'] );
	echo '<div class="thumbnail no-padding center" style="padding-left: 0px; padding-right: 0px; overflow: hidden;">
			<div class="row">
				<img class="center-image full-width" alt="' . $Movie ['name'] . '"
						src="http://image.tmdb.org/t/p/w780' . $Movie ['still_path'] . '">
				<div class="col-md-12">
					<h1 class="bold">"' . $Movie ['name'] . '"</h1>
					<h3>aired : ' . $Movie ['air_date'] . '</h3>
				</div>
			</div>
		</div>
		<div class="thumbnail no-padding">
			<div class="row">
				<div class="col-md-12">
					<h1 class="center-vertical">Plot</h1><br />
					<p>' . $Movie ['overview'] . '</p>
				</div>
			</div>
		</div>';
}
?>