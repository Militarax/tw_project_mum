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

<?php  
	echo file_get_contents("resources/carousel.html");
?>

<div class="main-container">
	<main>	
	<ul style="list-style-type: none">
<?php
$result = $db->query("SELECT track.id, artists.name, track.title_track, albums.img_link, count(id_user) from `artists` join `track` on artists.id = track.id_artist left outer join `albums` on albums.id_track = track.id left outer join voted_list_track on track.id = voted_list_track.id_track group by track.id, artists.name, track.title_track, albums.img_link order by 5 DESC;") or die("mysql_error");	

	for($i = 0; $i < 10; $i = $i + 1) {
		$row = $result->fetch_assoc();
		if(is_null($row['img_link']))
			$row['img_link'] = "http://localhost/tw/img/noalbum.png";
		echo' <li>
		<audio id="music'.$i.'">
			<source src="http://localhost/tw/music/'.$row["title_track"].'.mp3" type="audio/mpeg">
		</audio>
		<div class="main-player">
			<div class="album-image" style="background-image: url('.$row["img_link"].')">
				<button id="mini-play'.$i.'" onclick="play('.$i.')" class="little-player play on"></button>
				<button id="mini-pause'.$i.'" onclick="pause('.$i.')" class="little-player pause off"></button>
			</div>
			<div class="track-link">
				<p class="marquee resp"><span><a onclick="redirect(`'.$row["name"].'`)" id = "player_name_track'.$i.'">'.$row["name"].' - '.$row["title_track"].'</a></span></p>
				<a onclick="redirect(`'.$row["name"].'`)" id = "player_name_track'.$i.'" class="noneresp">'.$row["name"].' - '.$row["title_track"].'</a>
			</div>';

		if(isset($_SESSION['email'])) {
			echo '<div class="add"><button onclick="mini_menu('.$i.')" class="add-button"></button></div>
				<div id="mini-menu'.$i.'" class="mini-menu">
					<ul style="list-style-type: none">';

			$id_track = $db->query('SELECT * from `track` where `title_track` = "'.$row['title_track'].'"')->fetch_assoc()['id'];
			if($db->query("SELECT count(*) from `track_list` where `id_track` = '".$id_track."' and `id_user` = '".$_SESSION['id']."'")->fetch_assoc()['count(*)'] == 0)
				echo '<li><a id="add_or_remove_a'.$i.'" onclick="add_track(`'.$row['title_track'].'`, `'.$i.'`)">Add</a></li>';
			else
				echo '<li><a id="add_or_remove_a'.$i.'" onclick="add_track(`'.$row['title_track'].'`, `'.$i.'`)">Remove</a></li>';
			
			if($db->query("SELECT count(*) from `voted_list_track` where `id_track` = '".$id_track."' and `id_user` = '".$_SESSION['id']."'")->fetch_assoc()['count(*)'] == 0)
				echo '<li><a id="vote_a'.$i.'" onclick="vote_track(`'.$row['title_track'].'`, `'.$i.'`)">Vote</a></li>';
			else
				echo '<li><a id="vote_a'.$i.'" onclick="vote_track(`'.$row['title_track'].'`, `'.$i.'`)">Unvote</a></li>';
			echo'</ul></div></div></li>';
		}
	}
	$db->close();
?>
	</ul>
	</main>
</div>

<?php  
	echo file_get_contents("resources/player.html");
?>
</body>
</html>