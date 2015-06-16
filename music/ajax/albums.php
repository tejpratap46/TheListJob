<?php
error_reporting ( 0 );
$q = $_GET ['i'];
if ($q) {
	$url = 'http://itunes.apple.com/lookup?entity=album&id=' . urlencode ( $q );
	$json = json_decode ( file_get_contents ( $url ) );
	$i = 0;
	if (isset ( $json->results [0] )) {
		foreach ( $json->results as $item ) {
			if ($i == 0) {
				$i ++;
			} else {
				$results [] = array (
						'img' => str_replace ( '100x100', '200x200', $item->artworkUrl100 ),
						'title' => $item->collectionName . ' - ' . $item->artistName,
						'text' => $item->primaryGenreName,
						'collectionid' => $item->collectionId,
						'url' => $item->collectionViewUrl
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
					<a href="songs.php?i=' . $results [$i] ['collectionid'] . '"><div class="thumbnail">
						<img style="width: 100%;" src="' . $results [$i] ['img'] . '" alt="' . $results [$i] ['title'] . '">
						<div class="caption">
							<h2 class="center ellipsis" title="' . $results [$i] ['title'] . '">' . $results [$i] ['title'] . '</h2>
							<p class="center ellipsis">' . $results [$i] ['text'] . '</p>
						</div>
					</div></a>
				</div>';
	if ($i % 4 == 3) {
		echo '</div>';
	}
}
?>