<?php
error_reporting ( 0 );

$title = array (
		"Top Rated",
		"Popular",
		"Up Coming",
		"Now Playing",
		"IMDB Top 250",
		"Highest Revenue"
);
$url = array (
		"toprated",
		"popular",
		"upcoming",
		"nowplaying",
		"imdb250",
		"discover"
);

$titleGenre = array (
		"Action",
		"Adventure",
		"Animation",
		"Comedy",
		"Crime",
		"Documentary",
		"Drama",
		"Family",
		"Fantasy",
		"Foreign",
		"History",
		"Horror",
		"Music",
		"Mystery",
		"Romance",
		"Science Fiction",
		"TV Movie",
		"Thriller",
		"War",
		"Western"
		);

$urlGenre = array (
		"28",
		"12",
		"16",
		"35",
		"80",
		"99",
		"18",
		"10751",
		"14",
		"10769",
		"36",
		"27",
		"10402",
		"9648",
		"10749",
		"878",
		"10770",
		"53",
		"10752",
		"37"
);

echo '<div id="categories" class="thumbnail center"><h1 class="bold">Categories</h1></div>';

for($i = 0; $i < count ( $title ); $i ++) {
	if ($i % 3 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-md-4">
					<a href="lists.php?t=' . $url [$i] . '"><div class="thumbnail">
						<div class="caption">
							<h2 class="center ellipsis">' . $title [$i] . '</h2>
						</div>
					</div></a>
				</div>';

	if ($i % 3 == 2) {
		echo '</div>';
	}
}

echo '<hr><div id="genres" class="thumbnail center"><h1 class="bold">Genres</h1></div>';

for($i = 0; $i < count ( $urlGenre ); $i ++) {
	if ($i % 3 == 0) {
		echo '<div class="row">';
	}
	echo '<div class="col-md-4">
					<a href="genre.php?t=' . $urlGenre [$i] . '"><div class="thumbnail">
						<div class="caption">
							<h2 class="center ellipsis">' . $titleGenre [$i] . '</h2>
						</div>
					</div></a>
				</div>';
	if ($i % 3 == 2) {
		echo '</div>';
	}
}
?>
