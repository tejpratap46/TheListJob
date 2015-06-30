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

<title>Music List</title>

<!-- Bootstrap core CSS -->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<!-- my styles -->
<link href="../css/style.css" rel="stylesheet">
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
					<li><a href="../movies">Movies</a></li>
					<li><a href="../tv">Tv Shows</a></li>
					<li class="active"><a href="../music">Music</a></li>
					<li><a href="../podcast">Podcast</a></li>
					<form class="navbar-form navbar-left" role="search" action="search.php">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="q" value="">
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

	<div class="container" style="width: 100%; margin-top: 70px;">
		
		<div class="row bottom full-width" style="height: 100px; background: #F9F9F9;">
			<div style="width:10%; float: left;">
				<img id="player-img" style="width: 100px; height: 100px;" src="../images/music-512.png" alt="">
			</div>
			<div style="width:90%;">
				<h5 id="player-name">Click On A Track Below To Play</h5>
				<audio id="player-url" controls="controls" src="" autoplay loop></audio>
			</div>
		</div>

		<div class="jumbotron">
			<div class="row">
				<div class="row" id="songs">
				</div>
			</div>
		</div>
		<div class="jumbotron" id="loading">
			<div class="row" id="items">
				<img class="center-image" alt="loading..."
					src="../images/loading.gif">
			</div>
		</div>
	</div>
	<div class="notification"></div>
	<!-- /container -->
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>

	<script type="text/javascript">
	var q = getParameterByName('i');
	setTimeout(function () {
		$("#loading").toggle(100);
		ajaxCall();
	}, 50);

	function getParameterByName(name) {
	    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
	        results = regex.exec(location.search);
	    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	$(document).click(function(event) {
		$id = $(event.target).attr('id');
		if ($id == 'playTrack') {
			name = $(event.target).attr('data-name');
			mp3 = $(event.target).attr('data-mp3');
			img = $(event.target).attr('data-image');

			$('#player-url').attr('src', mp3);
			$('#player-img').attr('src', img);
			$('#player-name').text(name);
		}
	});
	
	function ajaxCall(){
		$("#loading").show(100);
		$.getJSON('../api/music/music.getplaylist.php?apikey=tejpratap&email=' + <?php echo "'".$_COOKIE ['tljusername']."'" ?>, function(json, textStatus) {
			$("#loading").hide(100);
			console.log(json);
			if (json.status == 1) {
				music = json.music;
				show = '';
				for (var i =  0; i < music.length; i++) {
					song = json.music[i];
					// song = '<div>' + song + '</div>';
					// mp3 = $(song).find('url').text();
					// name = $(song).find('name').text();
					// img = $(song).find('img').text();
					songArray = new Array();
					songArray = song.split(':::');
					name = songArray[0];
					mp3 = songArray[1];
					img = songArray[2];
					show += '<div class="col-sm-2">';
						show += '<div class="thumbnail">';
							show += '<button style="background: url(\''+img+'\') no-repeat center; height: 150px; width: 100%;" id="playTrack" data-name="'+name+'" data-mp3="'+mp3+'" data-image="'+img+'" class="btn btn-primary"><span style="font-size: 3em;" class="glyphicon glyphicon-play" aria-hidden="true"></span></button>';
							show += '<div class="caption">';
								show += '<p title="'+name+'" class="ellipsis">'+name+'</p>';
							show += '</div>';
						show += '</div>';
					show += '</div>';
				}
				$('#songs').html(show);
			}else{
				$('.notification').stop().text('Error : ' + json.error).show('fast').delay(3000).hide('fast');
			}
		});
	}
	</script>
</body>
</html>