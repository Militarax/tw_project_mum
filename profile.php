<?php 	
	session_start();
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
	if(!isset($_SESSION['email']))
		header('Location: /tw/login.php');
	$display = 0;
	$email = $_SESSION['email'];
	if(isset($_GET['email'])) {
		if($_GET['email'] != $_SESSION['email']) {
			$display = 1;
			$email = $_GET['email'];
		}
		$if_user_exists = $db->query("select count(*) from users where email = '".$_GET['email']."'")->fetch_assoc()['count(*)'];
		if($if_user_exists == 0)
			header('Location: /tw/index.php');		
	}
	$_SESSION['prev_page'] = "profile.php?email=".$email;
 ?>

<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
	<link rel="stylesheet" type="text/css" href="css/comments.css">
	<title>MD&MTC</title>
	<script src="js/scripts.js">
	</script>
	<script src="js/player.js">
	</script>
	<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
	<script src="js/file.js"></script>
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
				<a href="feed.php">News</a>
				<a href="profile.php">Profile</a>
				<a href="logout.php">logout</a>
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
					<li><a href="feed.php">news</a></li>
					<li><a href="profile.php">profile</a></li>
					<li><a href="logout.php">logout</a></li>
				</ul>
			</div>
		</div>
	</nav>
</header>




<div class="main-container">
	<main>
		<?php
		if($display == 0) {
			echo '<div class="top"><h1>Your playlist</h1></div>';
			$current_page_user_id = $_SESSION['id'];
		}
		else {
			echo '<div class="top"><h1>'.$_GET['email'].' playlist</h1></div>';
			$current_page_user_id = $db->query("select * from users where email = '".$_GET['email']."'")->fetch_assoc()['id'];
		}
		?>
		<div class="play-list">
			<ul style="list-style-type: none">
<?php
	$result = $db->query("SELECT * FROM `track` join `track_list` on track_list.id_track = track.id join artists on track.id_artist = artists.id left outer join albums on albums.id_track = track.id where track_list.id_user = ".$current_page_user_id) or die("mysql_error");	
	for($i = 0; $i < $result->num_rows; $i = $i + 1) {
		$row = $result->fetch_assoc();
		if(is_null($row['img_link']))
			$row['img_link'] = "http://localhost/tw/img/noalbum.png";
		echo '<li>
			<audio id="music'.$i.'">
				<source src="http://localhost/tw/music/'.str_replace(' ', '%20', $row["title_track"]).'.mp3" type="audio/mpeg">
			</audio>
			<div class="main-player">
				<div class="album-image" style="background-image: url('.$row["img_link"].')">
					<button id="mini-play'.$i.'" onclick="play('.$i.')" class="little-player play on"></button>
					<button id="mini-pause'.$i.'" onclick="pause('.$i.')" class="little-player pause off"></button>
				</div>
				<div class="track-link">
					<p class="marquee resp"><span><a href="artist.php?name='.$row["name"].'" id = "player_name_track'.$i.'">'.$row["name"].' - '.$row["title_track"].'</a></span></p>
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
			echo'</ul></div></div></li>';
		}
	}

?>

			</ul>
		</div>
	</main>
</div>
<?php  
	if($display == 0)
		echo '<div class="export"><h3><a>Import playlist</a></h3>
			
			<input type="file" accept="application/JSON" id="fileToLoad">
			<button onclick="loadFileAsText()">Load Selected File</button>
		</div>';

echo '<div class="export"><h3><a id="export_a" onclick="get_file(`'.$email.'`)">Export playlist</a></h3></div>'
?>

<div class="comment-container">
	<div class="comm-and-input">
		<?php	
				echo '
					<form method="post" action="send_comment_to_anotherone.php">
						<textarea name="comment" placeholder="Write your comment" required=""></textarea>
						<input style="display:none"name="id" value="'.$current_page_user_id.'">
						<div><button type="submit" value="Submit">Submit</button></div>
					</form>	';
				
		?>	
						<ul>
						<?php  
							$result = $db->query("SELECT personalcomments.id, personalcomments.owner, personalcomments.id_user_commented, personalcomments.comment, personalcomments.date, users.email FROM `personalcomments` join `users` on personalcomments.id_user_commented = users.id where owner = ".$current_page_user_id." order by 5 desc limit 0, 15") or die("mysql_error");
							$rows = $result->num_rows;
							if ($rows != 0) {
								for($i = 0; $i < $rows; $i = $i + 1) {
									$row = $result->fetch_assoc();
									echo '<li><div class="user_comment"><p>User: <a href ="profile.php?email='.$row['email'].'">'.$row['email'].'</a></p><p>Date: '.$row['date'].'</p><hr><div class="text_comment"><p>Comment: '.$row['comment'].'</p></div>';
									if(isset($_SESSION['admin']) and $_SESSION['admin'] == 1)
										echo '<hr><div class="delete_div"><a href="delete_anotherone_comment.php?id='.$row['id'].'" class ="delete_button">Delete comment</a></div></div></li>';
									else
										echo '</div></li>';
								}
							}
							else
								echo '<li><div class="comment"><p>No comments!</p></div></li>';
							
							echo'</ul>';
							
							if ($rows > 15)
								echo '<div class="more_comm"><a>More comments</a></div>';
						?>
		</div>
	</div>
</div>
	<?php
		echo file_get_contents("resources/player.html"); 
	 	$db->close();
	 ?>
</body>
</html>