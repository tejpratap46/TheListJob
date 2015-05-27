<?php
error_reporting ( 0 );
$url = 'https://feedwrangler.net/api/v2/podcasts/categories';
$json = json_decode ( file_get_contents ( $url ) );
$json = $json->podcasts;
for($i = 0; $i < count ( $json ); $i ++) {
	$item = $json [$i];
	$results [] = array (
			'img' => $item->image_url,
			'title' => $item->title,
			'category_id' => $item->category_id
	);
}
for($i = 0; $i < count ( $results ); $i ++) {
	if ($i % 4 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-3">
					<div class="thumbnail">
						<a href="category.php?i='. $results [$i] ['category_id'] .'"><img style="width: 100%;" src="' . $results [$i] ['img'] . '" alt="' . $results [$i] ['title'] . '" hidden></a>
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
