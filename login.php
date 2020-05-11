<?php 
	session_start();
	if(isset($_SESSION['email']))
		header('Location: /tw/index.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<script src="js/scripts.js">
	</script>
</head>
<body>
	<header>
		<nav>
			<div class="nonresponsive">
				<div class="left">
					<a href="index.php">main page</a>
					<a href="albums.php">albums</a>
				</div>
				<div class="center"><a href="index.php">MD&MTC</a></div>
				<div class="right">
					<a href="register.php">registration</a>
					<a href="login.php">login</a>
				</div>
			</div>
			<div class="responsive">
				<div id="menu" class="main_name">
					<a href="index.php">MD&MTC</a>
				</div>
				<div class="menu">
					<a href="javascript:void(0);"  onclick="NavBarResponsivity()">Menu</a>
				</div>
				<div id="text" class="text-off">
					<ul>
						<li><a href="index.php">main page</a></li>
						<li><a href="albums.php">albums</a></li>
						<li><a href="register.php">registration</a></li>
						<li><a href="login.php">login</a></li>
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<div class="form">
	  <form action="login_proccesing.php" class="form-container" method="POST">
	    <h1>Login</h1>
	    <label for="email"><b>Email</b></label>
	    <input type="email" placeholder="Enter Email" name="email" required>

	    <label for="password"><b>Password</b></label>
	    <input type="password" placeholder="Enter Password" name="password" minlength="6" maxlength="128" required>
	    <button type="submit" class="btn">Login</button>
	  </form>
	</div>
</body>
</html>