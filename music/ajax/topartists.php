<?php
// error_reporting ( 0 );
$url = 'http://ws.audioscrobbler.com/2.0/?tag=pop&limit=130&method=tag.getWeeklyArtistChart&api_key=2803b2bcbc53f132b4d4117ec1509d65&format=json&api_sig=1cf6f31944e4e0b0982595e5367f5659';
$json = json_decode ( file_get_contents ( $url ), true );
$i = 0;
$json = $json['weeklyartistchart'];
if (isset ( $json['artist'] [0] )) {
	foreach ( $json['artist'] as $item ) {
		$results [] = array (
				'img' => $item['image'][2]["#text"],
				'title' => $item['name'],
				'mbid' => $item['mbid'],
		);
	}
}
for($i = 0; $i < count ( $results ); $i ++) {
	if ($i % 4 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-3">
					<a href="search.php?q=' . $results [$i] ['title'] . '">
						<div class="thumbnail">
							<div style="height: 200px; overflow: hidden;" class="center-image" >
								<img style="width: 100%;" src="' . $results [$i] ['img'] . '" alt="' . $results [$i] ['title'] . '">
							</div>
							<div class="caption">
								<h2 class="center ellipsis" title="' . $results [$i] ['title'] . '">' . $results [$i] ['title'] . '</h2>
							</div>
						</div>
					</a>
				</div>';
	if ($i % 4 == 3) {
		echo '</div>';
	}
}
?>