<?php
error_reporting ( 0 );
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="favicon.ico">

<title>The List Job</title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- my styles -->
<link href="css/style.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="navbar-fixed-top.css" rel="stylesheet">
</head>

<body>
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
					echo "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>" . $_COOKIE ['ifiusername'] . "<span class='caret'></span></a>";
					echo "<ul class='dropdown-menu' role='menu'>";
					echo "<li><a href='#'>Profile</a></li>";
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

	<div class="container" style="width: 100%; margin-top: 70px;">
		<!-- Main component for a primary marketing message or call to action -->
		<div class="jumbotron blue-theme">
			<h1>The List Job</h1>
			<p>Great Stuff To Do Next.</p>
		</div>
		<div class="jumbotron">
			<div class="row">
				<div class="col-sm-6 col-md-4">
					<a href="movies"><div class="thumbnail">
						<img style="width: 100%;" src="images/movie-512.png" alt="Movies">
						<div class="caption">
							<h2 class="center">Movie Lists</h2>
							<p class="center ellipsis">Collection Of Awsome Movie List For You.</p>
						</div>
					</div></a>
				</div>
				<div class="col-sm-6 col-md-4">
					<a href="tv"><div class="thumbnail">
						<img style="width: 100%;" src="images/tv-512.png" alt="TV Show">
						<div class="caption">
							<h2 class="center">Tv Shows</h2>
							<p class="center ellipsis">Collection Of Awsome Tv Shows For You.</p>
						</div>
					</div></a>
				</div>
				<div class="col-sm-6 col-md-4">
					<a href="music"><div class="thumbnail">
						<img style="width: 100%;" src="images/music-512.png" alt="Music">
						<div class="caption">
							<h2 class="center">Music Lists</h2>
							<p class="center ellipsis">Collection Of Awsome Music For You.</p>
						</div>
					</div></a>
				</div>
			</div>
		</div>
	</div>
	<!-- /container -->
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
