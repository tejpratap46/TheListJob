<?php
// error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET['i']) {
	$Movies = $tmdb->getPersonCredits ($_GET['i']);
	echo '<h1 class="bold"> Worked In</h1>';
	for($i = 0; $i < count ( $Movies ['cast'] ); $i ++) {
		if ($i % 4 == 0) {
			echo '<div class="row">';
		}
		echo '<div class="col-sm-6 col-md-3">
						<a href="../movies/movie.php?i=' . $Movies ['cast'] [$i] ['id'] . '"><div class="thumbnail">
							<img style="width: 100%;" src="http://image.tmdb.org/t/p/w185' . $Movies ['cast'] [$i] ['poster_path'] . '" alt="' . $Movies ['cast'] [$i] ['title'] . '">
							<div class="caption">
								<h2 class="center ellipsis" title="' . $Movies ['cast'] [$i] ['title'] . '">' . $Movies ['cast'] [$i] ['title'] . '</h2>
								<p>As - ' . $Movies ['cast'] [$i] ['character'] . '</p>
							</div>
						</div></a>
					</div>';
		if ($i % 4 == 3) {
			echo '</div>';
		}
	}
}
?>