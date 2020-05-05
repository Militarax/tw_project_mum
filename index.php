<?php 	
	include 'carousel.php';
	session_start();
	include 'print_tracks.php';
	$_SESSION['prev_page'] = "artist.php";
	if (!isset($_GET['page']))
		$page = 1;
	else
		$page = $_GET['page'];
 ?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
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
		echo '<a href="register.php">registration</a>
				<a href="login.php">login</a>';
	}
	else {
		echo '<a href="profile.php">Profile</a>
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
		echo '<li><a href="profile.php">profile</a></li>
		<li><a href="logout.php">logout</a></li>';
	}
?>
				</ul>
			</div>
		</div>
	</nav>
</header>

<?php  
	print_carousel();
?>

<div class="main-container">
	<main>	
	<ul id = "ul_player_list" style="list-style-type: none">
	<?php
		print_tracks($page); 
	 ?>
	</ul>
	<div class="more_comm"><a onclick="get_new_tracks()">Another tracks</a></div>
	</main>
</div>

<?php  
	echo file_get_contents("resources/player.html");
?>
</body>
</html>


