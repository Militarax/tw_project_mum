<?php 
	session_start();
	if(!isset($_SESSION['email'])) {
		header('location: /tw/login.php');
	}
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
	$email = $_SESSION['email'];
	
	if(isset($_GET['email'])) {
		if($_GET['email'] != $_SESSION['email']) {
			$email = $_GET['email'];
		}
		$if_user_exists = $db->query("select count(*) from users where email = '".$_GET['email']."'")->fetch_assoc()['count(*)'];
		if($if_user_exists == 0)
			header('Location: /tw/index.php');
		$id_user = $db->query("select * from users where email = '".$_GET['email']."'")->fetch_assoc()['id'];
	}			
	
	$result = $db->query("SELECT * FROM `track` join `track_list` on track_list.id_track = track.id join artists on track.id_artist = artists.id left outer join albums on albums.id_track = track.id where track_list.id_user = ".$id_user) or die("mysql_error");	
	
	$arr_tracks = array();
	for($i = 0; $i < $result->num_rows; $i = $i + 1) {
		$row = $result->fetch_assoc();
		$track = array('location' => 'http//localhost/tw/music/'.$row['title_track'].'mp3', 'title'=> $row['title_track'], 'creator' => $row['name']);
		array_push($arr_tracks, $track);
	}
	$playlist = array('playlist' => array('title' => $email.' playlist', 'creator' => $email, 'track' => $arr_tracks));
	echo json_encode($playlist);
?>