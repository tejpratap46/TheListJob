<?php
error_reporting ( 0 );
include '../../TMDb.php';

$tmdb = new TMDb ( 'c2c73ebd1e25cbc29cf61158c04ad78a' );
// $config = $tmdb->getConfig ();
if ($_GET ['i']) {
	$Movies = $tmdb->getTvCast ( $_GET ['i'] );
	echo '<h2 class="bold">Cast</h2>';
	$count = min(count ( $Movies ['cast'] ), 6);
	for($i = 0; $i < $count; $i ++) {
		if ($i % 6 == 0) {
			echo '<div class="row">';
		}
		echo '<div class="col-sm-2">
					<div class="thumbnail">
						<a href="../people/people.php?i='.$Movies ['cast'] [$i] ['id'].'">
							<img style="width: 100%;" src="http://image.tmdb.org/t/p/w185' . $Movies ['cast'] [$i] ['profile_path'] . '" alt="' . $Movies ['cast'] [$i] ['original_title'] . '">
							<div class="caption">
								<h3 class="center ellipsis" title="' . $Movies ['cast'] [$i] ['name'] . '">' . $Movies ['cast'] [$i] ['name'] . '</h3>
								<p class="center ellipsis">As ' . $Movies ['cast'] [$i] ['character'] . '</p>
							</div>
						</a>
					</div>
				</div>';
		if ($i % 6 == 5 || $i==$count-1) {
			echo '</div>';
		}
	}
}
?>