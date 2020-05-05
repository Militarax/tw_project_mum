<?php
	session_start();
	if(!isset($_SESSION['email'])) {
		header('location: /tw/login.php');
	}
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
	$tracks = json_decode($_POST['data'])->{'playlist'}->{'track'};
	
	$result = $db->query("SELECT * FROM `track` join `track_list` on track_list.id_track = track.id join artists on track.id_artist = artists.id left outer join albums on albums.id_track = track.id where track_list.id_user = ".$_SESSION['id']) or die("mysql_error");	 
 	

	$number_tracks = count($tracks);
 	$if_exist = array_fill(0, $number_tracks, false);
	for($i = 0; $i < $result->num_rows; $i = $i + 1) {
		$row = $result->fetch_assoc();
		for($q = 0; $q < $number_tracks; $q = $q + 1) {
			if($row['title_track'] == $tracks[$q]->{'title'} and $row['name'] == $tracks[$q]->{'creator'})
				$if_exist[$q] = true;
		}
	}

	for($i = 0; $i < $number_tracks; $i = $i + 1) {
		if($if_exist[$i] == false) {
			$stmt = $db->prepare('SELECT * from `track` where `title_track` = ?');
			$stmt->bind_param('s', $tracks[$i]->{'title'}); 
			$stmt->execute();
			$result = $stmt->get_result();
			$id_track = $result->fetch_assoc()['id'];
			$user_id = $_SESSION['id'];

			$db->query("insert into track_list(`id_user`, `id_track`) values (".$user_id.", ".$id_track.")");
		}
	}
	echo 'done';
 ?>