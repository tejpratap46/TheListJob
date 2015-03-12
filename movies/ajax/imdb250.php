<?php
error_reporting ( 0 );
if ($_GET['p'] == 1) {
	$url = 'http://ajax.googleapis.com/ajax/services/feed/load?v=2.0&q=http://feeds.s-anand.net/imdbtop250&num=250';
	$json = json_decode ( file_get_contents ( $url ) );
	$Movies = $json->{'responseData'}->{'feed'}->{'entries'};
	for($i = 0; $i < count ( $Movies ); $i ++) {
		if ($i % 4 == 0) {
			echo '<div class="row">';
		}
		$id = str_replace ( "http://www.imdb.com/title/", "", $Movies [$i]->{'link'} );
		$id = str_replace ( "/", "", $id );
		echo '<div class="col-sm-6 col-md-3">
				
						<a href="movie.php?i=' . $id . '"><div class="thumbnail">
							<div class="caption">
								<h2 class="center ellipsis">' . $Movies [$i]->{'title'} . '</h2>
								<p class="center ellipsis">' . $Movies [$i]->{'contentSnippet'} . '</p>
							</div>
						</div></a>
					</div>';
		if ($i % 4 == 3) {
			echo '</div>';
		}
	}
}
?>