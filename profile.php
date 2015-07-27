<?php
error_reporting ( 0 );
if (!isset($_COOKIE['tljusername'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" type="image/png" href="favicon.png"/>

<title><?php echo $_COOKIE['tljusername']; ?> :: The List Job</title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- my styles -->
<link href="css/style.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="navbar-fixed-top.css" rel="stylesheet">
</head>

<body class="jumbotron">
	<!-- Fixed navbar -->
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">The List Job</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li class="active"><a href="index.php">Home</a></li>
					<li><a href="movies">Movies</a></li>
					<li><a href="tv">Tv Shows</a></li>
					<li><a href="music">Music</a></li>
					<li><a href="podcast">Podcast</a></li>
					<!-- 					<form class="navbar-form navbar-left" role="search"> -->
					<!-- 						<div class="form-group"> -->
					<!-- 							<input type="text" class="form-control" placeholder="Search"> -->
					<!-- 						</div> -->
					<!-- 						<button type="submit" class="btn btn-default">Search</button> -->
					<!-- 					</form> -->
				</ul>
				<ul class="nav navbar-nav navbar-right">
				<?php
				if ($_COOKIE ['tljusername']) {
					echo "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>" . $_COOKIE ['tljusername'] . "<span class='caret'></span></a>";
					echo "<ul class='dropdown-menu' role='menu'>";
					echo "<li><a href='profile.php'>Profile</a></li>";
					echo "<li class='divider'></li>";
					echo "<li class='dropdown-header'>Say Good Bye</li>";
					echo "<li><a href='logout.php'>Logout</a></li>";
					echo "</ul>";
					echo "</li>";
				} else {
					echo '<a type="button" class="btn btn-default navbar-btn" href="login.php">Sign in</a>';
				}
				?>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container" style="width: 100%; margin-top: 50px;">
		<!-- Main component for a primary marketing message or call to action -->
		<div class="alert alert-success center">
			<h1 class="bold ellipsis" style="color: white;"><?php echo $_COOKIE['tljusername']; ?></h1>
			<p>Great Stuff To Do Next Only For You.</p>
		</div>

		<div class="btn-group btn-group-justified">
		  <a href="#movies" class="btn btn-primary bold">Movies</a>
		  <a href="#tv" class="btn btn-success bold">Tv</a>
			<a href="#music" class="btn btn-info bold">Music</a>
		  <a href="#podcast" class="btn btn-danger bold">Podcast</a>
		</div>

		<hr>
		<div class="well">
			<div class="thumbnail center"><h1 class="bold">Movies TO-DO</h1></div>
			<div class="row" id="movies"></div>
		</div>
		<hr>
		<div class="well">
			<div class="thumbnail center"><h1 class="bold">TV Show's Following</h1></div>
			<div class="row" id="tv"></div>
		</div>
		<hr>
		<div class="well">
			<div class="thumbnail center"><h1 class="bold">Music Intrested In</h1></div>
			<div class="row" id="music"></div>
		</div>
		<hr>
		<div class="well">
			<div class="thumbnail center"><h1 class="bold">Podcast's Subscribed</h1></div>
			<div class="row" id="podcast"></div>
		</div>
	</div>
	<div class="notification"></div>
	<!-- /container -->
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
	setTimeout(function () {
		getMovies();
		getPodcast();
		getTv();
		getMusic();
	}, 50);

	function getMovies () {
		$(".notification").text('Loading...').show(100);
		$.getJSON('api/movie/movie.gettodo.php?apikey=tejpratap&limit=7&email=' + <?php echo "'".$_COOKIE['tljusername']."'" ?>, function(json, textStatus) {
			$(".notification").hide(100);
			if (json.status == 1) {
				movies = json.movies;
				// console.log(movies[0]);
				display = '<div class="well row"><h2 class="center bold">Total : ' + json.total + ' Movies</h2></div>';
				for (var i =  0; i < movies.length; i++) {
					var m = "<div>" + movies[i] + "</div>";
					name = $(m).children('name').first().text();
					id = $(m).children('id').first().text();
					display = display + '<div class="col-md-3">';
						display = display + '<div class="thumbnail">';
							display = display + '<a href="movies/movie.php?i='+ id +'">';
							display = display + '<h1 class="ellipsis center bold">' + (i+1) + '</h1>';
							display = display + '<div class="caption">';
								display = display + '<h3 class="ellipsis center">' + name + '</h1>';
							display = display + '</div>';
						display = display + '</div>';
						display = display + '</a>';
					display = display + '</div>';
				}
					display = display + '<div class="col-md-3">';
						display = display + '<div class="thumbnail">';
							display = display + '<a href="user/movie.php">';
							display = display + '<h1 class="ellipsis center bold">*</h1>';
							display = display + '<div class="caption">';
								display = display + '<h3 class="ellipsis center">More</h1>';
							display = display + '</div>';
						display = display + '</div>';
						display = display + '</a>';
					display = display + '</div>';
			}
			$('#movies').html(display);
		});
	}
	function getTv () {
		$(".notification").text('Loading...').show(100);
		$.getJSON('api/tv/tv.getsubscription.php?apikey=tejpratap&limit=7&email=' + <?php echo "'".$_COOKIE['tljusername']."'" ?>, function(json, textStatus) {
			$(".notification").hide(100);
			if (json.status == 1) {
				tvs = json.tvs;
				// console.log(movies[0]);
				display = '<div class="well row"><h2 class="center bold">Total : ' + json.total + ' Shows</h2></div>';
				for (var i =  0; i < tvs.length; i++) {
					var m = "<div>" + tvs[i] + "</div>";
					name = $(m).children('name').first().text();
					id = $(m).children('id').first().text();
					display = display + '<div class="col-md-3">';
						display = display + '<div class="thumbnail">';
							display = display + '<a href="tv/movie.php?i='+ id +'">';
							display = display + '<h1 class="ellipsis center bold">' + (i+1) + '</h1>';
							display = display + '<div class="caption">';
								display = display + '<h3 class="ellipsis center">' + name + '</h1>';
							display = display + '</div>';
						display = display + '</div>';
						display = display + '</a>';
					display = display + '</div>';
				}
					display = display + '<div class="col-md-3">';
						display = display + '<div class="thumbnail">';
							display = display + '<a href="user/tv.php">';
							display = display + '<h1 class="ellipsis center bold">*</h1>';
							display = display + '<div class="caption">';
								display = display + '<h3 class="ellipsis center">More</h1>';
							display = display + '</div>';
						display = display + '</div>';
						display = display + '</a>';
					display = display + '</div>';
			}
			$('#tv').html(display);
		});
	}
	function getMusic () {
		$(".notification").text('Loading...').show(100);
		$.getJSON('api/music/music.gettodo.php?apikey=tejpratap&email=' + <?php echo "'".$_COOKIE['tljusername']."'" ?>, function(json, textStatus) {
			$(".notification").hide(100);
			if (json.status == 1) {
				music = json.music;
				// console.log(movies[0]);
				display = '<div class="well row"><h2 class="center bold">Total : ' + json.total + ' Music</h2></div>';
				for (var i =  0; i < music.length; i++) {
					var m = "<div>" + music[i] + "</div>";
					name = $(m).children('name').first().text();
					id = $(m).children('id').first().text();
					display = display + '<div class="col-md-3">';
						display = display + '<div class="thumbnail">';
							display = display + '<a href="music/search.php?q='+ name +'">';
							display = display + '<h1 class="ellipsis center bold">' + (i+1) + '</h1>';
							display = display + '<div class="caption">';
								display = display + '<h3 class="ellipsis center center">' + name + '</h1>';
							display = display + '</div>';
						display = display + '</div>';
						display = display + '</a>';
					display = display + '</div>';
				}
					display = display + '<div class="col-md-3">';
						display = display + '<div class="thumbnail">';
							display = display + '<a href="user/music.php">';
							display = display + '<h1 class="ellipsis center bold">*</h1>';
							display = display + '<div class="caption">';
								display = display + '<h3 class="ellipsis center">More</h1>';
							display = display + '</div>';
						display = display + '</div>';
						display = display + '</a>';
					display = display + '</div>';
			}
			$('#music').html(display);
		});
	}
	function getPodcast () {
		$(".notification").text('Loading...').show(100);
		$.getJSON('api/podcast/podcast.getsubscription.php?apikey=tejpratap&limit=7&email=' + <?php echo "'".$_COOKIE['tljusername']."'" ?>, function(json, textStatus) {
			$(".notification").hide(100);
			if (json.status == 1) {
				podcasts = json.podcasts;
				// console.log(movies[0]);
				display = '<div class="well row"><h2 class="center bold">Total : ' + json.total + ' Channels</h2></div>';
				for (var i =  0; i < podcasts.length; i++) {
					var m = "<div>" + podcasts[i] + "</div>";
					name = $(m).children('name').first().text();
					rss = $(m).children('rss').first().text();
					display = display + '<div class="col-md-3">';
						display = display + '<div class="thumbnail">';
							display = display + '<a href="podcast/podcast.php?i='+ rss +'">';
							display = display + '<h1 class="ellipsis center bold">' + (i+1) + '</h1>';
							display = display + '<div class="caption">';
								display = display + '<h3 class="ellipsis center">' + name + '</h1>';
							display = display + '</div>';
						display = display + '</div>';
						display = display + '</a>';
					display = display + '</div>';
				}
					display = display + '<div class="col-md-3">';
						display = display + '<div class="thumbnail">';
							display = display + '<a href="user/podcast.php">';
							display = display + '<h1 class="ellipsis center bold">*</h1>';
							display = display + '<div class="caption">';
								display = display + '<h3 class="ellipsis center">More</h1>';
							display = display + '</div>';
						display = display + '</div>';
						display = display + '</a>';
					display = display + '</div>';
			}
			$('#podcast').html(display);
		});
	}
	</script>
</body>
</html>
