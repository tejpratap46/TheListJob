<?php
error_reporting ( 0 );
$url = 'https://itunes.apple.com/us/rss/toppodcasts/limit=20/json';
$json = json_decode ( file_get_contents ( $url ) );
$json = $json->feed->entry;
for($i = 0; $i < count ( $json ); $i ++) {
	$item = $json [$i];
	$results [] = array (
			'img' => str_replace ( '170x170', '200x200', $item->{'im:image'} [2]->{'label'} ),
			'title' => $item->{'title'}->{'label'},
			'text' => $item->{'summary'}->{'label'},
			'id' => $item->{'id'}->{'attributes'}
	);
}
for($i = 0; $i < count ( $results ); $i ++) {
	if ($i % 4 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-3">
					<div class="thumbnail">
						<a href="search.php?q='. $results [$i] ['title'] .'"><img style="width: 100%;" src="' . $results [$i] ['img'] . '" alt="' . $results [$i] ['title'] . '"></a>
						<div class="caption">
							<h2 class="center ellipsis">' . $results [$i] ['title'] . '</h2>
							<p class="center ellipsis">' . $results [$i] ['text'] . '</p>
						</div>
					</div>
				</div>';
	if ($i % 4 == 3) {
		echo '</div>';
	}
}
// print_r($json);
?>