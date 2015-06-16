<?php
error_reporting ( 0 );
$url = 'http://itunes.apple.com/us/rss/topsongs/limit=48/json';
$json = json_decode ( file_get_contents ( $url ) );
$json = $json->feed->entry;
for($i = 0; $i < count ( $json ); $i ++) {
	$item = $json [$i];
	$results [] = array (
			'img' => str_replace ( '170x170', '200x200', $item->{'im:image'} [2]->{'label'} ),
			'title' => $item->{'title'}->{'label'},
			'text' => $item->{'category'}->{'attributes'}->{'label'},
			'collection' => $item->{'im:collection'}->{'im:name'}->{'label'},
			'url' => $item->{'link'} [0]->{'attributes'}->{'href'},
			'collectionid' => $item->{'id'}->{'attributes'}->{'im:id'},
			'track' => $item->{'link'} [1]->{'attributes'}->{'href'} 
	);
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
// print_r($json);
?>