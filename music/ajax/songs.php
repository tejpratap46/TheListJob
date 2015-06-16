<?php
// error_reporting ( 0 );
$q = $_GET ['i'];
if ($q) {
	$url = 'http://itunes.apple.com/lookup?entity=song&id=' . urlencode ( $q );
	$json = json_decode ( file_get_contents ( $url ) );
	$i = 0;
	if (isset ( $json->results [1] )) {
		foreach ( $json->results as $item ) {
			if ($i == 0) {
				$i ++;
			} else {
				$results [] = array (
						'img' => str_replace ( '100x100', '200x200', $item->artworkUrl100 ),
						'title' => $item->trackName . ' - ' . $item->artistName,
						'text' => $item->primaryGenreName,
						'collection' => $item->collectionName,
						'url' => $item->trackViewUrl,
						'track' => $item->previewUrl
				);
			}
		}
	}
}
for($i = 0; $i < count ( $results ); $i ++) {
	if ($i % 4 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-3">
					<div class="thumbnail">
						<img style="width: 100%;" src="' . $results [$i] ['img'] . '" alt="' . $results [$i] ['title'] . '">
						<div class="caption">
							<h2 class="center ellipsis" title="' . $results [$i] ['title'] . '">' . $results [$i] ['title'] . '</h2>
							<p class="center ellipsis">' . $results [$i] ['collection'] . '</p>
							<a style="background:black;" href="'.$results [$i] ['url'].'"><img style="height:30px;" src="itunes.jpg" alt="On iTunes"></a>
							<audio style="width: 100%;" controls="controls" preload="none">
								<source src="' . $results [$i] ['track'] . '">
							</audio>
						</div>
					</div>
				</div>';
	if ($i % 4 == 3) {
		echo '</div>';
	}
}
?>