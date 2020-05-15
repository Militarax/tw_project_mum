<?php 
	session_start();
	include 'connection.php';
	if(isset($_SESSION['admin']) and $_SESSION['admin'] == 1 and isset($_GET['id'])) {
		echo 
		$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
		$stmt = $db->prepare("DELETE FROM `personalcomments` WHERE id = ?");
		$stmt->bind_param('s', $_GET['id']);
		$stmt->execute();
		$db->close();
		header('location: /tw/'.$_SESSION['prev_page']);
	}
	else
		header('Location: /tw/login.php');
?>