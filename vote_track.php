<?php
	session_start();
	
	if(isset($_SESSION['email']) && isset($_POST['title_track'])) {
		$user ='root';
		$db = new mysqli('localhost', $user, '', 'mydb') or die('Unable to connect'); 
		
		$user_id = $_SESSION['id'];
		
		$stmt = $db->prepare('SELECT * from `track` where `title_track` = ?');
		$stmt->bind_param('s', $_POST['title_track']); 
		$stmt->execute();
		$result = $stmt->get_result();
		$id_track = $result->fetch_assoc()['id'];
		
		if($db->query("SELECT count(*) from `voted_list_track` where `id_track` = '".$id_track."' and `id_user` = '".$_SESSION['id']."'")->fetch_assoc()['count(*)'] == 0)
			$db->query("insert into voted_list_track(`id_user`, `id_track`) values (".$user_id.", ".$id_track.")");
		else
			$db->query("delete from `voted_list_track` where id_user = ".$user_id." and id_track = ".$id_track);
		
		$db->close();
		
	}
	else
		header('Location: /tw/login.php');
?>