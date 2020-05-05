<?php
	include 'connection.php';
	session_start();
	if(isset($_SESSION['email']) && isset($_POST['title_track'])) {
		$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
		
		$user_id = $_SESSION['id'];
		$stmt = $db->prepare('SELECT * from `track` where `title_track` = ?');
		$stmt->bind_param('s', $_POST['title_track']); 
		$stmt->execute();
		$result = $stmt->get_result();
		$id_track = $result->fetch_assoc()['id'];
		
		
		$stmt = $db->prepare('select count(*) from `track_list` where `id_track` = ? and `id_user` = ?');
		$stmt->bind_param('ii', $id_track, $user_id); 
		$stmt->execute();
		$result = $stmt->get_result();
		$result = $result->fetch_assoc()['count(*)'];
		
		if($result == 0)
			$db->query("insert into track_list(`id_user`, `id_track`) values (".$user_id.", ".$id_track.")");
		else
			$db->query("delete from `track_list` where id_user = ".$user_id." and id_track = ".$id_track);
		
		$db->close();
	}
	else 
		header("Location: /tw/login.php")
?>