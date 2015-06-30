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

	<div class="container" style="width: 100%; margin-top: 70px;">
		<!-- Main component for a primary marketing message or call to action -->
		<div class="thumbnail center">
			<h1 class="bold">Music Lists</h1>
			<p>Music We All Love.</p>
			<form action="soundcloud.php" method="get">
				<input value="" id="searchText" name="q" onfocus="{this.value = '<?php echo $_GET['q']?>'}" onblur="{this.value = ''}" class="half-width" type="text" placeholder="Search On Soundcolud" />
			</form>
			<hr>
			<div class="row">
				<button id="add" class="btn btn-success full-width bold" onclick="addToTodo();">Save This Search</button>
				<button id="remove" class="btn btn-danger full-width bold" onclick="addFromTodo();" style="display: none;">Remove From Saved</button>
			</div>
		</div>
		<div class="jumbotron">
			<div class="row" id="items"></div>
		</div>
		<div class="jumbotron" id="loading">
			<div class="row" id="items">
				<img class="center-image" alt="loading..."
					src="../images/loading.gif">
			</div>
		</div>
		<div class="notification">Loading...</div>
	</div>
	<!-- /container -->
	<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script
		src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>

	<script type="text/javascript">
	var q = getParameterByName('q');
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

	function ajaxCall(){
		$("#loading").toggle(100);
		var xmlhttp = new XMLHttpRequest();
	    xmlhttp.onreadystatechange = function() {
	        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	        	var pre = document.getElementById("items").innerHTML;
	        	document.getElementById("items").innerHTML =pre +  xmlhttp.responseText;
	        	$("#loading").toggle(100);
	        }
	    }
	    xmlhttp.open("GET", "ajax/search.php?q=" + q, true);
	    xmlhttp.send();
	}

	function addToTodo() {
		name = q;
		$(".notification").text('Loading...').show(100);
		$.getJSON('../api/music/music.addtodo.php?apikey=tejpratap&name='+ name +'&email=' + <?php echo "'".$_COOKIE['tljusername']."'"; ?>, {param1: 'value1'}, function(json, textStatus) {
			$(".notification").hide(100);
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

	function addToPlaylist(name,url,img) {
		$(".notification").text('Loading...').show(100);
		$.getJSON('../api/music/music.addtoplaylist.php?apikey=tejpratap&name='+ name +'&url='+ url +'&img='+ img +'&email=' + <?php echo "'".$_COOKIE['tljusername']."'"; ?>, {param1: 'value1'}, function(json, textStatus) {
			$(".notification").hide(100);
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

	$(document).click(function(event) {
		id = $(event.target).attr('id');
		if (id == 'addtoplaylist') {
			name = $(event.target).attr('data-name');
			url = $(event.target).attr('data-url');
			img = $(event.target).attr('data-img');
			addToPlaylist(name,url,img);
		}
	});

	function addFromTodo() {
		name = q;
		$(".notification").text('Loading...').show(100);
		$.getJSON('../api/music/music.removetodo.php?apikey=tejpratap&name='+ name +'&email=' + <?php echo "'".$_COOKIE['tljusername']."'"; ?>, {param1: 'value1'}, function(json, textStatus) {
			$(".notification").hide(100);
			if (json.status == 1) {
				$(".notification").text('Removed').show(100).delay(3000).hide(100);
				$("#add").show();
				$("#remove").hide();
			}else{
				$(".notification").text('Error : ' + json.error).show(100).delay(3000).hide(100);
			}
		});
	}
	</script>
</body>
</html>
