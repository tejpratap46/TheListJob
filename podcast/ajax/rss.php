<?php
error_reporting(0);
$json = Parse($_GET['q']);
// echo json_encode($json);
$name = $json['channel']['title'];
$description = $json['channel']['description'][0];
$url = $_GET['q'];
$link = $json['channel']['link'];
if (isset ( $json['channel']['item'] [0] )) {
  foreach ( $json['channel']['item'] as $item ) {
    $results [] = array (
        'title' => $item['title'],
        'pubDate' => $item['pubDate'],
        'track' => $item['enclosure']['@attributes']['url']
    );
  }
}

function Parse ($url) {
    $fileContents= file_get_contents($url);
    $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
    $fileContents = trim(str_replace('"', "'", $fileContents));
    $simpleXml = simplexml_load_string($fileContents);
    $json = json_encode($simpleXml);
    $jsonArray = json_decode($json,true);
    return $jsonArray;
}

echo '<div class="thumbnail center row">
			<h1 class="bold">' . $name . '</h1>
			<p>' . $description . '</p>
			<div class="thumbnail row">
				<button id="add" class="btn btn-success half-width" onclick="subscribe(\'' . str_replace("'","`",$name) . '\',\'' . $url . '\')">Subscribe</button>
				<button id="remove" class="btn btn-danger half-width" onclick="unsubscribe(\'' . $url . '\')" style="display: none;">UnSubscribe</button>
			</div>
			<a target="_blank" href="' . $link . '">Website</a>
		</div>';
for($i = 0; $i < count ( $results ); $i ++) {
	echo '<div class="row thumbnail">
			<h2 class="bold">'.$results [$i] ['title'].'</h2>
			<h4 class="bold">'.$results [$i] ['pubDate'].'</h4>
			<div class="row thumbnail">
				<div class="col-md-12 center-vertical center">
					<audio style="width: 100%;" controls="controls" preload="none">
						<source src="' . $results [$i] ['track'] . '">
					</audio>
				</div>
			</div>
			<div class="col-md-6" hidden>
				<button class="btn btn-primary full-width" onclick="playlist(\'' . $name." : ".$results [$i] ['title'] . '\',\'' . $results [$i] ['track'] . '\')">Add To Playlist</button>
			</div>
			<div class="col-md-12 center">
				<a target="_blank" href="' . $results [$i] ['track'] . '" class="btn btn-primary full-width" >Download</a>
			</div>
		</div>';
}
?>
