<?php
error_reporting ( 0 );
if ($_GET['q']) {
	$cat = explode("_", $_GET['q'])[1];
	$url = 'http://ajax.googleapis.com/ajax/services/feed/load?v=2.0&q=http://www.billboard.com/rss/charts/'. $cat .'&num=200';
	$json = json_decode ( file_get_contents ( $url ) );
	$Movies = $json->{'responseData'}->{'feed'}->{'entries'};
	for($i = 0; $i < count ( $Movies ); $i ++) {
		if ($i % 3 == 0) {
			echo '<div class="row">';
		}
		$id = str_replace ( ($i + 1) . ": ", "", $Movies [$i]->{'title'} );
		$id = str_replace ( "/", "", $id );
		echo '<div class="col-md-4">
						<a href="search.php?q=' . $id . '"><div class="thumbnail">
							<h1 class="center bold">'.($i + 1).'</h1>
							<div class="caption">
								<h2 class="center ellipsis">' . $Movies [$i]->{'title'} . '</h2>
								<p class="center ellipsis">' . $Movies [$i]->{'contentSnippet'} . '</p>
							</div>
						</div></a>
					</div>';
		if ($i % 3 == 2) {
			echo '</div>';
		}
	}
}

?>