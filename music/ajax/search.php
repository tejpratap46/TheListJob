<?php
error_reporting ( 0 );
$q = $_GET ['q'];
if ($q) {
	$url = 'http://itunes.apple.com/search?media=music&term=' . urlencode ( $q );
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
					'track' => $item->previewUrl 
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
						<a href="albums.php?i=' . $results [$i] ['artistId'] . '"><img style="width: 100%;" src="' . $results [$i] ['img'] . '" alt="' . $results [$i] ['title'] . '">
							<div class="caption">
								<h2 class="center ellipsis" title="' . $results [$i] ['title'] . '">' . $results [$i] ['title'] . '</h2>
								<p class="center ellipsis">' . $results [$i] ['collection'] . '</p>
							</div>
						</a>
						<a style="background:black;" href="'.$results [$i] ['url'].'"><img style="height:30px;" src="itunes.jpg" alt="On iTunes"></a>
						<audio style="width: 100%;" controls="controls" preload="none">
							<source src="' . $results [$i] ['track'] . '">
						</audio>
						<button id="" class="btn btn-primary full-width" onclick"addToPlaylist(\''.$results [$i] ['title'].'\',\''.$results [$i] ['track'].'\')">Add To Playlist</button>
					</div>
				</div>';
	if ($i % 4 == 3) {
		echo '</div>';
	}
}
?>