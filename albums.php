<?php 	
	session_start();
	include 'print_albums.php';
	$_SESSION['prev_page'] = "albums.php";
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
	<link>
	<link rel="stylesheet" type="text/css" href="css/style2.css">
	<title>MD&MTC</title>
	<script type="text/javascript">
		function NavBarResponsivity() {
			var x = document.getElementById("text");
			if (x.className === "text-off") {
				x.className = "text-on";
			} else {
				x.className = "text-off";
			}
		}
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
<section class="music-section-type">
			<h2 class="music-section-title">Music tags

			</h2>
			<ul class="music-tags">
				<div class="music-tag"
					style="background-image: url('https://images.pexels.com/photos/1763075/pexels-photo-1763075.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500');">
					<div class="music-tag-link" href="index.html">
						<a href="rockpage.html"></a>
					</div>
				</div>

				<div class="music-tag"
					style="background-image: url('https://images.pexels.com/photos/164936/pexels-photo-164936.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500');">
					<div class="music-tag-link" href="index.html">
						<a href="index.html"></a>
					</div>
				</div>
				<div class="music-tag"
					style="background-image: url('https://images.pexels.com/photos/219101/pexels-photo-219101.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500');">
					<div class="music-tag-link" href="index.html">
						<a href="index.html"></a>
					</div>
				</div>
				<div class="music-tag"
					style="background-image: url('https://images.pexels.com/photos/759832/pexels-photo-759832.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500');">
					<div class="music-tag-link" href="index.html">
						<a href="index.html"></a>
					</div>
				</div>
				<div class="music-tag"
					style="background-image: url('https://images.pexels.com/photos/210854/pexels-photo-210854.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500');">
					<div class="music-tag-link" href="index.html">
						<a href="index.html"></a>
					</div>
				</div>
				<div class="music-tag" style="background-image: url(img6.jpg);"></div>
			</ul>



		</section>


	<div class="main-container">
	<main>	
	<ul style="list-style-type: none">
<?php
print_albums($page); 
?>
	</ul>
	</main>
</div>


</body>

</html>