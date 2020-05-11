<?php 
	session_start();
	if(!isset($_SESSION['email']))
		header('Location: /tw/login.php');
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/feed.css">
	<title>MD&MTC</title>
	<script src="js/scripts.js">
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
</body>
	<main>
		<ul style="list-style-type: none">
			<?php 
				$result = $db->query("SELECT * FROM `rss` order by date desc limit 0, 50");
				for($i = 0; $i < $result->num_rows; $i = $i + 1){
					$row = $result->fetch_assoc();
					echo '<li><div><ul style="list-style-type: none">
							<li>'.$row['title'].'</li>
							<li><a href = "'.$row['link'].'">Link</a></li>
							<li>'.$row['description'].'</li>
							<li>'.$row['date'].'</li>
							</div></li>';
				}
				$db->close();
			?>
		</ul>
	</main>
</html>