<?php
error_reporting ( 0 );
$q = $_GET ['q'];
if ($q) {
	$url = 'http://api.soundcloud.com/tracks.json?client_id=YOUR_CLIENT_ID&q=' . urlencode ( $q );
	$json = json_decode ( file_get_contents ( $url ) );
	if (isset ( $json [0] )) {
		foreach ( $json as $item ) {
			$results [] = array (
					'img' => $item->artwork_url,
					'title' => $item->title,
					'waveform_url' => $item->waveform_url,
					'url' => $item->permalink_url,
					'user' => $item->user->id,
					'track' => $item->stream_url."?client_id=YOUR_CLIENT_ID" 
			);
		}
	}
}
for($i = 0; $i < count ( $results ); $i ++) {
	if ($i % 4 == 0) {
		echo '<div class="row">';
	}

	// for a default album art
	$img = "";

	if (strlen($results [$i] ['img']) > 0) {
		$img = $results [$i] ['img'];
	}else{
		$img = "../images/music-512.png";
	}
	echo '<div class="col-sm-6 col-md-3">
					<div class="thumbnail">
						<a href="clouduser.php?i=' . $results [$i] ['user'] . '" >
							<img style="width: 100%;" src="' . $img . '" alt="' . $results [$i] ['title'] . '">
							<div class="caption">
								<h2 class="center ellipsis">' . $results [$i] ['title'] . '</h2>
							</div>
						</a>
						<audio style="width: 100%;" controls="controls" preload="none">
							<source src="' . $results [$i] ['track'] . '">
						</audio>
					</div>
				</div>';
	if ($i % 4 == 3) {
		echo '</div>';
	}
}
?>