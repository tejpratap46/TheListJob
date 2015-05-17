<?php
// error_reporting ( 0 );
$q = $_GET ['q'];
if ($q) {
	$url = 'http://ajax.googleapis.com/ajax/services/feed/load?v=2.0&q=' . $q .'&num=200';
	$json = json_decode ( file_get_contents ( $url ) );
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
for($i = 0; $i < count ( $results ); $i ++) {
	echo '<div class="row thumbnail">
			<h2 class="bold">'.$results [$i] ['title'].'</h2>
			<h4 class="bold">'.$results [$i] ['publishedDate'].'</h4>
			<p>'.$results [$i] ['contentSnippet'].'</p>
			<div class="thumbnail">
				<audio style="width: 100%;" controls="controls" preload="none">
					<source src="' . $results [$i] ['track'] . '">
				</audio>
			</div>
		</div>';
}
?>