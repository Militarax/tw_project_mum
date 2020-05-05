<?php 
	session_start();	
	if(!isset($_POST['comment']) || !isset($_SESSION['email'])) {
		header('location: /tw/login.php');
	}
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
	$stmt = $db->prepare("INSERT INTO artistcomments VALUES(NULL, ?, ?, ?, (select sysdate()))");
	$stmt->bind_param('sss', $_SESSION['id'], $_POST['id'], $_POST['comment']);
	$stmt->execute();
	$db->close();
	header('location: /tw/'.$_SESSION['prev_page']);
 ?>