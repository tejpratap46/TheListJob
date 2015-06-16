<?php
// error_reporting ( 0 );
$q = $_GET ['i'];
if ($q) {
	$url = 'https://itunes.apple.com/us/rss/topsongs/limit=48/genre='.urlencode ( $q ).'/json';
	$json = json_decode ( file_get_contents ( $url ), true );
	$json = $json['feed'];
	$i = 0;
	if (isset ( $json['entry'] [0] )) {
		foreach ( $json['entry'] as $item ) {
			$results [] = array (
					'img' => str_replace ( '60x60', '200x200', $item["im:image"][1]['label'] ),
					'title' => $item["im:name"]['label'],
					'text' => $item["im:artist"]['label'],
					// 'collectionid' => explode("/id", explode("?", $item['id']['label'])[0])[1] ,
					'url' => $item['link'][1]['attributes']['href']
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
						<img style="width: 100%;" src="' . $results [$i] ['img'] . '" alt="' . $results [$i] ['title'] . '">
						<div class="caption">
							<h2 class="center ellipsis" title="' . $results [$i] ['title'] . '">' . $results [$i] ['title'] . '</h2>
							<p class="center ellipsis">' . $results [$i] ['text'] . '</p>
						</div>
						<audio style="width: 100%;" controls="controls" preload="none">
							<source src="' . $results [$i] ['url'] . '">
						</audio>
					</div>
				</div>';
	if ($i % 4 == 3) {
		echo '</div>';
	}
}
?>