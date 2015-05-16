<?php
error_reporting ( 0 );
$q = $_GET ['q'];
if ($q) {
	$url = 'http://itunes.apple.com/search?entity=podcast&term=' . urlencode ( $q );
	$json = json_decode ( file_get_contents ( $url ) );
	if (isset ( $json->results [0] )) {
		foreach ( $json->results as $item ) {
			$results [] = array (
					'img' => str_replace ( '100x100', '200x200', $item->artworkUrl100 ),
					'title' => $item->trackName . ' - ' . $item->artistName,
					'text' => $item->primaryGenreName,
					'collection' => $item->collectionName,
					'url' => $item->trackViewUrl,
					'artistId' => $item->artistId,
					'feedUrl' => $item->feedUrl
			);
		}
	}
}
for($i = 0; $i < count ( $results ); $i ++) {
	if ($i % 4 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-3">
					<div class="thumbnail">
						<a href="podcast.php?i=' . $results [$i] ['feedUrl'] . '"><img style="width: 100%;" src="' . $results [$i] ['img'] . '" alt="' . $results [$i] ['title'] . '">
						<div class="caption">
							<h2 class="center ellipsis">' . $results [$i] ['title'] . '</h2>
							<p class="center ellipsis">' . $results [$i] ['collection'] . '</p>
						</div></a>
							<a style="background:black;" href="'.$results [$i] ['url'].'"><img style="height:30px;" src="itunes.jpg" alt="On iTunes"></a>
					</div>
				</div>';
	if ($i % 4 == 3) {
		echo '</div>';
	}
}
?>