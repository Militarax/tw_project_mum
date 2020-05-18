<?php
	session_start();

	$user ='root';
	$db = new mysqli('localhost', $user, '', 'mydb') or die('Unable to connect');
	
	
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
	<script src="js/stat.js">
	</script>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>
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
		echo '<a href="feed.php">news</a>
				<a href="profile.php">profile</a>
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

<h2 style="text-align: center; margin:200px"><a id="getstat_csv" onclick="get_file_csv()">CSV</a></h2>
<h2 style="text-align: center; margin:200px"><a id="getstat_pdf" onclick="get_file_pdf()">PDF</a></h2>

</body>
</html>