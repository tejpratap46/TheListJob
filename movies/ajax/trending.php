<?php
//error_reporting(0);
$url = file_get_contents("https://api.trakt.tv/movies/trending.json/e05f7d4719998c2d5010a9aaa1a1fc60");
$json = json_decode ( file_get_contents ( $url ) );
$i = 0;
if (isset ( $json [0] )) {
  foreach ( $json as $item ) {
      $results [] = array (
          'poster' => str_replace ( 'original', 'thumbnail', $item->images->poster ),
          'title' => $item->title,
          'overview' => $item->overview,
          'tagline' => $item->tagline,
          'trailer' => $item->trailer,
          'imdb_id' => $item->imdb_id
      );
  }
}
echo json_encode($results);
?>
