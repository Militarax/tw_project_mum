<?php
	session_start();
	
	if(isset($_SESSION['email']) && isset($_POST['album_title'])) {
		include 'connection.php';
		$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db)); 
		
		$user_id = $_SESSION['id'];
		
		$stmt = $db->prepare('SELECT * from `albums` where `albums_title` = ?');
		$stmt->bind_param('s', $_POST['album_title']); 
		$stmt->execute();
		$result = $stmt->get_result();
		$id_album = $result->fetch_assoc()['id'];
		
		if($db->query("SELECT count(*) from `voted_list_album` where `id_album` = '".$id_album."' and `id_user` = '".$_SESSION['id']."'")->fetch_assoc()['count(*)'] == 0)
			$db->query("insert into voted_list_albums(`id_user`, `id_album`) values (".$user_id.", ".$id_album.")");
		else
			$db->query("delete from `voted_list_album` where id_user = ".$user_id." and id_album = ".$id_album);
		
		$db->close();
		
	}
	else
		header('Location: /tw/login.php');
?>