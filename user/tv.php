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
<link rel="shortcut icon" type="image/png" href="../favicon.png"/>

<title><?php echo $_COOKIE['tljusername']; ?> :: Movies :: The List Job</title>

<!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<!-- my styles -->
<link href="../css/style.css" rel="stylesheet">
<link href="../css/jquery.modal.css" rel="stylesheet">
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
					<li><a href="../index.php">Home</a></li>
					<li><a href="../movies">Movies</a></li>
					<li><a href="../tv">Tv Shows</a></li>
					<li><a href="../music">Music</a></li>
					<li><a href="../podcast">Podcast</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php
					if ($_COOKIE ['tljusername']) {
						echo "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>" . $_COOKIE ['tljusername'] . "<span class='caret'></span></a>";
						echo "<ul class='dropdown-menu' role='menu'>";
						echo "<li><a href='../profile.php'>Profile</a></li>";
						echo "<li class='divider'></li>";
						echo "<li class='dropdown-header'>Say Good Bye</li>";
						echo "<li><a href='../logout.php'>Logout</a></li>";
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
		<div>
      		<div class="thumbnail center"><h1 class="bold">TV TO-DO</h1></div>
			<div class="row" id="tv"></div>
		</div>
	<div class="well" id="modal" style="display:none; margin-top: 100px; overflow-y: scroll;">
		<div class="row" id="modelText"></div>
	    <a class="btn btn-danger full-width bold" href="#" rel="modal:close">Close</a>
  	</div>
	<div class="notification"></div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/jquery.modal.min.js"></script>
	<script type="text/javascript">
 	 pg = 1;

	setTimeout(function () {
		getTv(pg);
	}, 50);

  	$(window).scroll(function() {
	   if($(window).scrollTop() + $(window).height() == $(document).height()) {
		   pg = pg + 1;
			getTv(pg);
	   	}
	});

	function getTv () {
		$(".notification").text('Loading...').show(100);
		$.getJSON('../api/tv/tv.getsubscription.php?apikey=tejpratap&email=' + <?php echo "'".$_COOKIE['tljusername']."'" ?>, function(json, textStatus) {
			$(".notification").hide(100);
			if (json.status == 1) {
				tvs = json.tvs;
				// console.log(movies[0]);
				display = "";
				for (var i =  0; i < tvs.length; i++) {
					var m = "<div>" + tvs[i] + "</div>";
					name = $(m).children('name').first().text();
					id = $(m).children('id').first().text();
					display = display + '<div class="col-sm-4">';
						display = display + '<div class="thumbnail">';
							display = display + '<a href="../tv/movie.php?i='+ id +'">';
							display = display + '<h1 class="ellipsis center bold">' + (i+1) + '</h1>';
							display = display + '<div class="caption">';
								display = display + '<h3 class="ellipsis center">' + name + '</h1>';
							display = display + '</div>';
						display = display + '</a>';
						display = display + '<div class="row">';
						display = display + '<button class="btn btn-danger full-width bold" id="unsubscribe">Unsubscribe</button>';
						display = display + '<a class="btn btn-success full-width bold" href="#modal" rel="modal:open" id="quickInfo">Quick Info</a>';
						display = display + '</div>';
						display = display + '</div>';
					display = display + '</div>';
				}
			}
			$('#tv').html(display);
		});
	}

	$(document).click(function(e) {
    $id = $(e.target).attr('id');
    if ($id == 'unsubscribe') {
		id = $(e.target).parent().parent().children('a').first().attr('href');
		id = id.split("=")[1];
		$(".notification").text('Loading...').show(100);
		$.getJSON('../api/tv/tv.unsubscribe.php?apikey=tejpratap&id='+ id +'&email=' + <?php echo "'".$_COOKIE['tljusername']."'" ?>, function(json, textStatus) {
			if(json.status == 1){
				$(e.target).parent().parent().parent().html('');
				$(".notification").text('Removed').delay(1000).hide(100);
			}else{
				$(".notification").text('Error : ' + json.error).delay(3000).hide(100);
			}
		});
	}else if($id == 'quickInfo'){
		name = $(e.target).parent().parent().children('a').first().children('div').first().children('h3').text();
		$(".notification").text('Loading...').show(100);
		$('#modelText').html('<h3>Loading...</h3>');
		$.getJSON('../tv/ajax/quickinfo.php?q='+ name, function(json, textStatus) {
			if(json.status == 1){
				$(".notification").hide(100);
				data = '';
				data += '<h2 class="bold">'+ json.name +'</h2>';
				data += '<h3 class="bold">Latest Episode</h3>';
				data += '<h4>'+ json.latest_episode[0] +'</h4>';
				data += '<h4>'+ json.latest_episode[1] +'</h4>';
				data += '<h4>'+ json.latest_episode[2] +'</h4>';
				data += '<h3 class="bold">Next Episode</h3>';
				data += '<h4>'+ json.next_episode[0] +'</h4>';
				data += '<h4>'+ json.next_episode[1] +'</h4>';
				data += '<h4>'+ json.next_episode[2] +'</h4>';
				data += '<h3 class="bold">Network</h3>';
				data += '<h4>'+ json.network +'</h4>';
				data += '<h3 class="bold">Runtime</h3>';
				data += '<h4>'+ json.runtime +'</h4>';
				$('#modelText').html(data);
			}else{
				$(".notification").text('Error : ' + json.error).delay(3000).hide(100);
			}
		});
	}
	});
	</script>
</body>
</html>
