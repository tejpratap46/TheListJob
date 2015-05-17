<?php
error_reporting ( 0 );
include '../../TMDb.php';

$title = array (
		"Top Songs",
		"Top Albums",
		"Billboard"
);
$url = array (
		"topsongs",
		"topalbums",
		"billboard"
);

for($i = 0; $i < count ( $title ); $i ++) {
	echo '<div class="col-sm-6 col-md-4">
					<a href="lists.php?q=' . $url [$i] . '"><div class="thumbnail">
						<div class="caption">
							<h2 class="center ellipsis bold">' . $title [$i] . '</h2>
						</div>
					</div></a>
				</div>';
}
?>