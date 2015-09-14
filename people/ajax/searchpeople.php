<?php
// error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
$Movies = $tmdb->searchPerson ($_GET['q'], $_GET['p']);
for($i = 0; $i < count ( $Movies ['results'] ); $i ++) {
	if ($i % 4 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-3">
					<a href="people.php?i=' . $Movies ['results'] [$i] ['id'] . '"><div class="thumbnail">
						<img style="width: 100%;" src="http://image.tmdb.org/t/p/w185' . $Movies ['results'] [$i] ['profile_path'] . '" alt="' . $Movies ['results'] [$i] ['name'] . '">
						<div class="caption">
							<h2 class="center ellipsis" title="' . $Movies ['results'] [$i] ['name'] . '">' . $Movies ['results'] [$i] ['name'] . '</h2>
						</div>
					</div></a>
				</div>';
	if ($i % 4 == 3) {
		echo '</div>';
	}
}
?>