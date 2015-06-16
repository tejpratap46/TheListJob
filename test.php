<?php
$json = Parse($_GET['q']);
// echo json_encode($json);
$name = $json['channel']['title'];
$description = $json['channel']['description'];
$url = $_GET['q'];
$link = $json['channel']['link'];
if (isset ( $json['channel']['item'] [0] )) {
  foreach ( $json['channel']['item'] as $item ) {
    $results [] = array (
        'title' => $item['title'],
        'link' => $item['link'],
        'pubDate' => $item['pubDate'],
        'track' => $item['enclosure']['@attributes']['url']
    );
  }
}

echo json_encode($results);

function Parse ($url) {
    $fileContents= file_get_contents($url);
    $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
    $fileContents = trim(str_replace('"', "'", $fileContents));
    $simpleXml = simplexml_load_string($fileContents);
    $json = json_encode($simpleXml);
    $jsonArray = json_decode($json,true);
    return $jsonArray;
}
?>
