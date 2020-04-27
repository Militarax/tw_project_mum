<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/register.css">
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

	
	<form action="register_proccesing.php" method="POST">
	  <div class="container">
	    <h1>Register</h1>	
	    <hr>
	    <label for="email"><b>Email</b></label>
	    <input type="email" placeholder="Enter Email" name="email" required>

	    <label for="password"><b>Password</b></label>
	    <input type="password" placeholder="Enter Password" name="password" minlength="6" maxlength="128" required>

	    <label for="password2"><b>Repeat Password</b></label>
	    <input type="password" placeholder="Repeat Password" name="password2" minlength="6" maxlength="128" required>
	    <hr>

	    <button type="submit" class="registerbtn">Register</button>
	    <a href="login.php">Sign in</a>
	  </div>
	</form>
</body>
</html>