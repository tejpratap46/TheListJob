<?php
error_reporting ( 0 );
require_once 'itunes.php';

$results = iTunes::search ( 'taylor swift', array (
		'country' => 'NL' 
) )->results;

// $albums = iTunes::lookup(909253, 'id', array(
// 'entity' => 'album'
// ))->results;

// $url = 'http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsSearch?media=music&term=' . urlencode ( 'taylor swift' );
// $json = json_decode ( file_get_contents ( $url ) );
// if (isset ( $json->results [0] )) {
// foreach ( $json->results as $item ) {
// $results [] = array (
// 'img' => str_replace ( '100x100', '200x200', $item->artworkUrl100 ),
// 'title' => $item->trackName . ' - ' . $item->artistName,
// 'text' => $item->primaryGenreName,
// 'url' => $item->trackViewUrl,
// 'track' => $item->previewUrl
// );
// }
// }
echo json_encode ( $results );
?>