<?php
	session_start();

	$user ='root';
	$db = new mysqli('localhost', $user, '', 'mydb') or die('Unable to connect');
	
	$stmt = $db->prepare('SELECT track.id, artists.name, track.title_track, albums.img_link from `track` left outer join albums on track.id = albums.id_track left outer join artists on track.id_artist = artists.id where track.id = ?') or die("mysql_error");
	$stmt->bind_param('s', $_GET['id']); 
	$stmt->execute();
	$result = $stmt->get_result();
	
	$track_row = $result->fetch_assoc();
	
	if(!isset($_GET['id']) || $result->num_rows == 0) {
		header('location: /tw/index.php');
	}
	$_SESSION['prev_page'] = "comment_a_play.php?id=".$_GET['id'];
 ?>

<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/play.css">
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
	<main>	
	<?php
		if(is_null($track_row['img_link']))
				$track_row['img_link'] = "http://localhost/tw/img/noalbum.png";
			echo'
			<audio id="music'."0".'">
				<source src="http://localhost/tw/music/'.str_replace(' ', '%20', $track_row["title_track"]).'.mp3" type="audio/mpeg">
			</audio>
			<div class="main-player">
				<div class="album-image" style="background-image: url('.$track_row["img_link"].')">
					<button id="mini-play'."0".'" onclick="play('."0".')" class="little-player play on"></button>
					<button id="mini-pause'."0".'" onclick="pause('."0".')" class="little-player pause off"></button>
				</div>
				<div class="track-link">
					<p class="marquee resp"><span><a onclick="redirect_to_artist(`'.$track_row["name"].'`)" id = "player_name_track'."0".'">'.$track_row["name"].' - '.$track_row["title_track"].'</a></span></p>
					<a onclick="redirect_to_artist(`'.$track_row["name"].'`)" class="noneresp">'.$track_row["name"].' - '.$track_row["title_track"].'</a>
				</div>';

			if(isset($_SESSION['email'])) {
				echo '<div class="add-vote-div"><button onclick="mini_menu('."0".')" class="add-button"></button></div>
					<div id="mini-menu'."0".'" class="mini-menu">
						<ul style="list-style-type: none">';

				$id_track = $db->query('SELECT * from `track` where `title_track` = "'.$track_row['title_track'].'"')->fetch_assoc()['id'];
				if($db->query("SELECT count(*) from `track_list` where `id_track` = '".$id_track."' and `id_user` = '".$_SESSION['id']."'")->fetch_assoc()['count(*)'] == 0)
					echo '<li><a id="add_or_remove_a'."0".'" onclick="add_track(`'.$track_row['title_track'].'`, `'."0".'`)">Add</a></li>';
				else
					echo '<li><a id="add_or_remove_a'."0".'" onclick="add_track(`'.$track_row['title_track'].'`, `'."0".'`)">Remove</a></li>';
				
				if($db->query("SELECT count(*) from `voted_list_track` where `id_track` = '".$id_track."' and `id_user` = '".$_SESSION['id']."'")->fetch_assoc()['count(*)'] == 0)
					echo '<li><a id="vote_a'."0".'" onclick="vote_track(`'.$track_row['title_track'].'`, `'."0".'`)">Vote</a></li>';
				else
					echo '<li><a id="vote_a'."0".'" onclick="vote_track(`'.$track_row['title_track'].'`, `'."0".'`)">Unvote</a></li>';
				echo '<li><a href="comment_a_play.php?id='.$track_row['id'].'">Comment</a></li>';
				echo'</ul></div>';
			}
			echo '</div></li>';
		
	 ?>
	</main>
</div>
</div>
	<div class="comment-container">
				<div class="comm-and-input">
		<?php	
			if(isset($_SESSION['email'])) {
				echo '
					<form method="post" action="send_comment_to_play.php">
						<textarea name="comment" placeholder="Write your comment" required=""></textarea>
						<input style="display:none" name="id" value="'.$track_row['id'].'">
						<input style="display:none" name="title_track" value="'.$track_row['title_track'].'">
						<input style="display:none" name="name" value="'.$track_row['name'].'">
						<div><button type="submit" value="Submit">Submit</button></div>
					</form>	';
					}
		?>	
						<ul>
					<?php  
						$result = $db->query("SELECT playcomments.id, playcomments.date, playcomments.comment, playcomments.id_user, users.email FROM `playcomments` join `users` on playcomments.id_user = users.id where playcomments.id_track = '".$track_row['id']."' order by 2 desc") or die("mysql_error");
							$rows = $result->num_rows >= 15 ? 15 : $result->num_rows;
							if ($rows != 0) {
								for($i = 0; $i < $rows; $i = $i + 1) {
									$row = $result->fetch_assoc();
									echo '<li><div class="user_comment"><p>User: <a href ="profile.php?email='.$row['email'].'">'.$row['email'].'</a></p><p>Date: '.$row['date'].'</p><hr><div class="text_comment"><p>Comment: '.$row['comment'].'</p></div>';
										if(isset($_SESSION['admin']) and $_SESSION['admin'] == 1)
											echo '<hr><div class="delete_div"><a href="delete_play_comment.php?id='.$row['id'].'" class ="delete_button">Delete comment</a></div></div></li>';
										else
											echo '</div></li>';
								}
							}
							else
								echo '<li><div class="comment"><p>No comments!</p></div></li>';
						echo'</ul>';
						if ($rows > 15)
							echo '<div class="more_comm"><a>More comments</a></div>';
						$db->close(); 
						?>
					</div>
				</div>

<?php 
echo file_get_contents("resources/player.html"); 
 ?>
</body>
</html>