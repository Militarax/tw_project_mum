<?php
	session_start();

	$user ='root';
	$db = new mysqli('localhost', $user, '', 'mydb') or die('Unable to connect');
	
	$stmt = $db->prepare('SELECT * from `artists` where artists.name = ?') or die("mysql_error");
	$stmt->bind_param('s', $_GET['name']); 
	$stmt->execute();
	$result = $stmt->get_result();
	
	$artist_row = $result->fetch_assoc();
	
	if(!isset($_GET['name']) || $result->num_rows == 0) {
		header('location: /tw/index.php');
	}
	$_SESSION['prev_page'] = "artist.php?name=".$_GET['name'];
 ?>

<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/artist.css">
	<link rel="stylesheet" type="text/css" href="css/comments.css">
	<title>MD&MTC</title>
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


<div class="main-container">
<div class="grid-container">
<div class="portret">

<?php
echo '
<div id="img">	<img src="'.$artist_row['img_link'].'" alt="">
</div>';
		if(isset($artist_row['name']))
			echo '<p>'.$artist_row['name'].'</p>';
		if(isset($artist_row['real_name']) and strlen($artist_row['real_name']) != 0)	
			echo '<p>'.$artist_row['real_name'].'</p>';
		if(isset($artist_row['genre']) and strlen($artist_row['genre']) != 0)		
			echo '<p>'.$artist_row['genre'].'</p>';
		if(isset($artist_row['born']) and strlen($artist_row['born']) != 0)		
			echo '<p>Born '.$artist_row['born'].'</p>';

$result = $db->query("SELECT * from `track` left outer join `albums` on albums.id_track = track.id where track.id_artist = '".$artist_row['id']."'") or die("mysql_error");	
$rows = $result->num_rows >= 3 ? 3 : $result->num_rows;
for($i = 0; $i < $rows; $i = $i + 1) {
	$row = $result->fetch_assoc();
	if(is_null($row['img_link']))
		$row['img_link'] = "http://localhost/tw/img/noalbum.png";
	echo'<audio id="music'.$i.'">
			<source src="http://localhost/tw/music/'.str_replace(' ', '%20', $row["title_track"]).'.mp3" type="audio/mpeg">
		</audio>
			<div class="main-player">
				<div class="album-image" style="background-image: url('.$row["img_link"].')">
					<button id="mini-play'.$i.'" onclick="play('.$i.')" class="little-player play on"></button>
					<button id="mini-pause'.$i.'" onclick="pause('.$i.')" class="little-player pause off"></button>
				</div>
				<div class="track-link">
					<p class="marquee resp"><span><a href="artist.php?name='.$artist_row['name'].'" id = "player_name_track'.$i.'">'.$artist_row['name'].' - '.$row["title_track"].'</a></span></p>
				</div>';								
		

		if(isset($_SESSION['email'])) {
			echo '<div class="add-vote-div"><button onclick="mini_menu('.$i.')" class="add-button"></button></div>
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
			echo '<li><a href="comment_a_play.php?id='.$row['id'].'">Comment</a></li>';
			echo'</ul></div>';
		}
		echo '</div>';
	}
echo "<div id='more-tracks'><a href='#'>Want more!</a></div>";

	echo '</div>
		<div class="bio">
			<h1>Biography</h1>
				<p>'.$artist_row['wiki'].'</p>		
		</div>
	</div>';
	$db->close();
?>
</div>
	<?php
		include 'print_artist_comments.php';
		echo file_get_contents("resources/player.html"); 
	 ?>
</body>
</html>