<?php
if (isset($_COOKIE['tljusername'])) {
	header("Location: index.php");
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
<link rel="icon" href="favicon.ico">

<title>The List Job :: Signin</title>

<!-- Bootstrap core CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="signin.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<div class="row center">
			<a href="index.php"><h1 class="form-signin-heading bold" >The List Job</h1></a>
		</div>
		<form class="form-signin thumbnail" method="post">
			<h1 class="form-signin-heading">Login</h1>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input id="email" type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
			<label for="inputPassword" class="sr-only">Password</label>
			<input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
			<div class="row">
				<div class="col-md-6">
					<button class="btn btn-lg btn-primary btn-block" type="button" onclick="login();">Log in</button>
				</div>
				<div class="col-md-6">
					<button class="btn btn-lg btn-success btn-block" type="button" onclick="register();">Register</button>
				</div>
			</div>
		</form>
	</div>
	<div class="notification"></div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="js/jquery.cookie.js"></script>
<script type="text/javascript">
	function login () {
		email = $('#email').val();
		password = $('#password').val();
		$('.notification').text('Loading...').show();
		$.getJSON('api/user/user.login.php?apikey=tejpratap&email=' + email + '&password=' + password, function(json, textStatus) {
			if (json.status == 1) {
				$('.notification').hide();
				$.cookie('tljusername', json.email, { expires: 365, path: '/' });
				window.location.href = "index.php";
			}else{
				$('.notification').text('Invalid Username Or Password').show();
			}
		});
	}

	function register () {
		email = $('#email').val();
		password = $('#password').val();
		$.getJSON('api/user/user.register.php?apikey=tejpratap&email=' + email + '&password=' + password, function(json, textStatus) {
			if (json.status == 1) {
				console.log(json.email);
				$.cookie('tljusername', json.email, { expires: 365, path: '/' });
				window.location.href = "index.php";
			}else{
				$('.notification').text('Username Already Existed.').show();
			}
		});
	}
</script>
</html>