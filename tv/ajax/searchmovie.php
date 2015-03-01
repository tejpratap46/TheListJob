<?php
error_reporting ( 0 );
include '../../TMDb.php';
if ($_GET ['q']) {
	$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
	$config = $tmdb->getConfig ();
	$Movies = $tmdb->searchTv ( $_GET ['q'] );
	for($i = 0; $i < count ( $Movies ['results'] ); $i ++) {
		if ($i % 4 == 0) {
			echo '<div class="row">';
		}
		echo '<div class="col-sm-6 col-md-3">
					<a href="movie.php?i=' . $Movies ['results'] [$i] ['id'] . '"><div class="thumbnail">
						<img style="width: 100%;" src="http://image.tmdb.org/t/p/w185' . $Movies ['results'] [$i] ['poster_path'] . '" alt="' . $Movies ['results'] [$i] ['original_name'] . '">
						<div class="caption">
							<h2 class="center ellipsis">' . $Movies ['results'] [$i] ['original_name'] . '</h2>
							<p class="center ellipsis">' . $Movies ['results'] [$i] ['first_air_date'] . '</p>
						</div>
					</div></a>
				</div>';
		if ($i % 4 == 3) {
			echo '</div>';
		}
	}
}
?>