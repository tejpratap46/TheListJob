<?php
error_reporting ( 0 );
$q = $_GET ['q'];
if ($q) {
	$url = 'http://ajax.googleapis.com/ajax/services/feed/load?v=2.0&q=' . $q .'&num=200';
	$json = json_decode ( file_get_contents ( $url ) );
	$name = $json->responseData->feed->title;
	$description = $json->responseData->feed->description;
	$url = $json->responseData->feed->feedUrl;
	$link = $json->responseData->feed->link;
	if (isset ( $json->responseData->feed->entries [0] )) {
		foreach ( $json->responseData->feed->entries as $item ) {
			$results [] = array (
					'title' => $item->title,
					'contentSnippet' => $item->contentSnippet,
					'author' => $item->author,
					'publishedDate' => $item->publishedDate,
					'track' => $item->link
			);
		}
	}
}

echo '<div class="thumbnail center row">
			<h1 class="bold">' . $name . '</h1>
			<p>' . $description . '</p>
			<div class="thumbnail row">
				<button id="add" class="btn btn-success half-width" onclick="subscribe(\'' . $name . '\',\'' . $url . '\')">Subscribe</button>
				<button id="remove" class="btn btn-danger half-width" onclick="unsubscribe(\'' . $url . '\')" style="display: none;">UnSubscribe</button>
			</div>
			<a target="_blank" href="' . $link . '">Website</a>
		</div>';
for($i = 0; $i < count ( $results ); $i ++) {
	echo '<div class="row thumbnail">
			<h2 class="bold">'.$results [$i] ['title'].'</h2>
			<h4 class="bold">'.$results [$i] ['publishedDate'].'</h4>
			<p>'.$results [$i] ['contentSnippet'].'</p>
			<div class="row thumbnail">
				<div class="col-md-12 center-vertical center">
					<audio style="width: 100%;" controls="controls" preload="none">
						<source src="' . $results [$i] ['track'] . '">
					</audio>
				</div>
			</div>
			<div class="col-md-6">
				<button class="btn btn-primary full-width" onclick="playlist(\'' . $name." : ".$results [$i] ['title'] . '\',\'' . $results [$i] ['track'] . '\')">Add To Playlist</button>
			</div>
			<div class="col-md-6">
				<a target="_blank" href="' . $results [$i] ['track'] . '" class="btn btn-danger full-width" >Download</a>
			</div>
		</div>';
}
?>
