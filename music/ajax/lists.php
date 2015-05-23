<?php
error_reporting ( 0 );

$trackTitle = array (
		"Top Songs",
		"Billboard Hot-100",
		"Billboard 200",
		"Billboard Dance Club",
		"Billboard R&B Songs",
		"Billboard Radio Songs",
		"Billboard Pop Songs",
		"Billboard Social-50",
		"Billboard Soundtracks",
		"Billboard Country Songs"
);
$trackUrl = array (
		"topsongs",
		"billboard_hot-100",
		"billboard_billboard-200",
		"billboard_dance-club-play-songs",
		"billboard_r-and-b-songs",
		"billboard_radio-songs",
		"billboard_pop-songs",
		"billboard_social-50",
		"billboard_soundtracks",
		"billboard_country-songs"
);

$albumTitle = array(
	'Top Albums'
);
$albumUrl = array (
	'topalbums'
);

$artistTitle = array(
	'Top Artists'
);
$artistUrl = array (
	'topartists'
);

$genre = array (
		"Alternative",
		"Classical",
		"Country",
		"Dance",
		"Disney",
		"Electronic",
		"Hip-Hop/Rap",
		"Instrumental",
		"Pop",
		"R&B/Soul",
		"Rock",
		"Soundtrack"
		);

$genreUrl = array (
		"20",
		"5",
		"6",
		"17",
		"50000063",
		"7",
		"18",
		"53",
		"14",
		"15",
		"21",
		"16"
		);

echo '<div class="thumbnail center"><h1 class="bold">Top Tracks</h1></div>';

for($i = 0; $i < count ( $trackTitle ); $i ++) {
	if ($i % 3 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-4">
					<a href="lists.php?q=' . $trackUrl [$i] . '"><div class="thumbnail">
						<div class="caption">
							<h2 class="center ellipsis">' . $trackTitle [$i] . '</h2>
						</div>
					</div></a>
				</div>';
	if ($i % 3 == 2 || $i == count ( $trackTitle )-1) {
		echo '</div>';
	}
}

echo '<hr><div class="thumbnail center"><h1 class="bold">Top Tracks By Genre</h1></div>';

for($i = 0; $i < count ( $genre ); $i ++) {
	if ($i % 3 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-4">
					<a href="genre.php?q=' . $genreUrl [$i] . '"><div class="thumbnail">
						<div class="caption">
							<h2 class="center ellipsis">' . $genre [$i] . '</h2>
						</div>
					</div></a>
				</div>';
	if ($i % 3 == 2 || $i == count ( $genreUrl )-1) {
		echo '</div>';
	}
}

echo '<hr><div class="thumbnail center"><h1 class="bold">Top Albums</h1></div>';

for($i = 0; $i < count ( $albumTitle ); $i ++) {
	if ($i % 3 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-4">
					<a href="lists.php?q=' . $albumUrl [$i] . '"><div class="thumbnail">
						<div class="caption">
							<h2 class="center ellipsis">' . $albumTitle [$i] . '</h2>
						</div>
					</div></a>
				</div>';
	if ($i % 3 == 2 || $i == count ( $albumTitle )-1) {
		echo '</div>';
	}
}
echo '<hr><div class="thumbnail center"><h1 class="bold">Top Albums By Genre</h1></div>';

for($i = 0; $i < count ( $genre ); $i ++) {
	if ($i % 3 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-4">
					<a href="albumgenre.php?q=' . $genreUrl [$i] . '"><div class="thumbnail">
						<div class="caption">
							<h2 class="center ellipsis">' . $genre [$i] . '</h2>
						</div>
					</div></a>
				</div>';
	if ($i % 3 == 2 || $i == count ( $genreUrl )-1) {
		echo '</div>';
	}
}

echo '<hr><div class="thumbnail center"><h1 class="bold">Top Artists</h1></div>';

for($i = 0; $i < count ( $artistTitle ); $i ++) {
	if ($i % 3 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-sm-6 col-md-4">
					<a href="lists.php?q=' . $artistUrl [$i] . '"><div class="thumbnail">
						<div class="caption">
							<h2 class="center ellipsis">' . $artistTitle [$i] . '</h2>
						</div>
					</div></a>
				</div>';
	if ($i % 3 == 2 || $i == count ( $artistTitle )-1) {
		echo '</div>';
	}
}
?>