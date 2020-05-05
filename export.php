<?php 
	session_start();
	if(!isset($_SESSION['email'])) {
		header('location: /tw/login.php');
	}
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
	$result = $db->query("SELECT * FROM `track` join `track_list` on track_list.id_track = track.id join artists on track.id_artist = artists.id left outer join albums on albums.id_track = track.id where track_list.id_user = ".$_SESSION['id']) or die("mysql_error");	
	
	$arr_tracks = array();
	for($i = 0; $i < $result->num_rows; $i = $i + 1) {
		$row = $result->fetch_assoc();
		$track = array('location' => 'http//localhost/tw/music/'.$row['title_track'].'mp3', 'title'=> $row['title_track'], 'creator' => $row['name']);
		array_push($arr_tracks, $track);
	}
	$playlist = array('playlist' => array('title' => $_SESSION['email'].' playlist', 'creator' => $_SESSION['email'], 'track' => $arr_tracks));
	echo json_encode($playlist);
?>