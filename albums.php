<?php 	
	session_start();
	include 'print_albums.php';
	$_SESSION['prev_page'] = "albums.php";
 ?>

<!DOCTYPE html>
<html lang="en-us">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link>
	<link rel="stylesheet" type="text/css" href="css/style2.css">
	<title>MD&MTC</title>
	<script src="js/scripts.js">
	</script>
	<script src="js/player.js">
	</script>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
</head>

<body>
<header>
	<nav>
		<div class="nonresponsive">
			<div class="left">
				<a href="index.php">main page</a>
				<a href="albums.php">albums</a>
			</div>
			<div class="center">
				<a href="index.php">MD&MTC</a>
			</div>
			<div class="right">
<?php
	if(!isset($_SESSION['email'])) {
		echo '
				<a href="register.php">registration</a>
				<a href="login.php">login</a>';
	}
	else {
		echo '<a href="feed.php">News</a>
				<a href="profile.php">Profile</a>
				<a href="logout.php">logout</a>';
	}
?>
					 
			</div>
		</div>
		<div class="responsive">
			<div class="main_name">
				<a href="index.php">MD&MTC</a>
			</div>
			<div class="menu">
				<a href="javascript:void(0);"  onclick="NavBarResponsivity()">Menu</a>
			</div>
			<div id="text" class="text-off">
				<ul>
					<li><a href="index.php">main page</a></li>
					<li><a href="albums.php">albums</a></li>
<?php
	if(!isset($_SESSION['email'])) {
		echo '<li><a href="register.php">registration</a></li>
			<li><a href="login.php">login</a></li>';
	}
	else {
		echo '<li><a href="feed.php">news</a></li>
				<li><a href="profile.php">profile</a></li>
				<li><a href="logout.php">logout</a></li>';
	}
?>
				</ul>
			</div>
		</div>
	</nav>
</header>

<main>
	<h2 class="music-section-title">Albums</h2>
<section class="music-section-type">
			
			<ul class="music-tags">

				<?php 
					print_albums(0);
				 ?>
			</ul>
		</section>
</main>
</body>

</html>