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
<link rel="shortcut icon" type="image/png" href="../favicon.png"/>

<title>Movie WatchList</title>

<!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<!-- my styles -->
<link href="../css/style.css" rel="stylesheet">
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
				<a class="navbar-brand" href="../">The List Job</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="../">Home</a></li>
					<li class="active"><a href="../movies">Movies</a></li>
					<li><a href="../tv">Tv Shows</a></li>
					<li><a href="../music">Music</a></li>
					<li><a href="../podcast">Podcast</a></li>
					<form class="navbar-form navbar-left" role="search" action="search.php">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="q" value="<?php echo $_GET['q']?>">
						</div>
					</form>
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
					echo '<a type="button" class="btn btn-default navbar-btn full-width" href="../login.php">Sign in</a>';
				}
				?>
				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container" style="width: 100%; margin-top: 70px;" id="info">
		<img class="center-image" alt="loading..." src="../images/loading.gif">
	</div>

	<div class="container" style="width: 100%;">
		<div class="jumbotron no-padding">
			<div class="row" id="casts"></div>
		</div>
		<div class="jumbotron no-padding">
			<div class="row" id="items"></div>
		</div>
	</div>

	<div class='notification' style='display: none'>Loading...</div>

	<!-- /container -->
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>

	<script type="text/javascript">
	setTimeout(function () {
	var i = getParameterByName('i');
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        	document.getElementById("info").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "ajax/info.php?i=" + i, true);
    xmlhttp.send();
	}, 50);

	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function getTrailer(){
		var i = getParameterByName('i');
		$('.notification').toggle();
		var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	        	$('.notification').toggle();
	        	document.getElementById("trailer").innerHTML = xmlhttp.responseText;
	        }	    }
	    xmlhttp.open("GET", "ajax/trailer.php?i=" + i, true);
	    xmlhttp.send();
	}

	function addToList (name, id, imdbId, image) {
		$('.notification').text('Loading...').show();
		$.getJSON('../api/movie/movie.addtodo.php?apikey=tejpratap&email=' + <?php echo "'".$_COOKIE['tljusername']."'"; ?> + '&name=' + name + '&id=' + id + '&imdbId=' + imdbId + '&image=' + image, function(json, textStatus) {
			$('.notification').hide();
			if(json.status == 1){
				$('.notification').text('Added').show(200).delay(3000).hide(200);
				$("#add").hide();
				$("#remove").show();
			}else if (json.error.indexOf('Already') > -1) {
				$('.notification').text('Already Added To TO-DO, Click Again To Romove Now?').show(200).delay(10000).hide(200);
				$("#add").hide();
				$("#remove").show();
			}else{
				$('.notification').text('Cannot Add : ' + json.error).show(200).delay(3000).hide(200);
			}
		});
	}

	function removeFromTodo(id){
		$(".notification").text('Loading...').show(100);
		$.getJSON('../api/movie/movie.removetodo.php?apikey=tejpratap&id='+ id +'&email=' + <?php echo "'".$_COOKIE['tljusername']."'" ?>, function(json, textStatus) {
			if(json.status == 1){
				$(".notification").text('Removed').delay(1000).hide(100);
				$("#add").show();
				$("#remove").hide();
			}else{
				$(".notification").text('Error : ' + json.error).delay(3000).hide(100);
			}
		});
	}

	var casts = false;
	var sim = false;

	$(window).scroll(function() {
	   if($(window).scrollTop() + $(window).height() == $(document).height()) {
			if(!casts){
			   var i = getParameterByName('i');
			   $('.notification').toggle();
				var xmlhttp = new XMLHttpRequest();
			    xmlhttp.onreadystatechange = function() {
			        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			        	$('.notification').toggle();
			        	document.getElementById("casts").innerHTML = xmlhttp.responseText;
			        }
			    }
			    xmlhttp.open("GET", "ajax/moviecast.php?i=" + i, true);
			    xmlhttp.send();
			    casts = true;
		   }else if(!sim){
		   	var i = getParameterByName('i');
			   $('.notification').toggle();
				var xmlhttp = new XMLHttpRequest();
			    xmlhttp.onreadystatechange = function() {
			        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			        	$('.notification').toggle();
			        	document.getElementById("items").innerHTML = xmlhttp.responseText;
			        }
			    }
			    xmlhttp.open("GET", "ajax/similar.php?i=" + i, true);
			    xmlhttp.send();
			    sim = true;
		   }
	   }
	});
	</script>
</body>
</html>
