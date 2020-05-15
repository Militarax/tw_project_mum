<?php 
	session_start();	
	if(!isset($_POST['title']) || !isset($_SESSION['email'])) {
		header('location: /tw/login.php');
	}
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
	$stmt = $db->prepare("INSERT INTO albumcomments VALUES(NULL, ?, ?, ?, (select sysdate()))");
	$stmt->bind_param('sss', $_SESSION['id'], $_POST['title'], $_POST['comment']);
	$stmt->execute();


	$email = $_SESSION['email'];
	$description = $email." commented ".$_POST['title']." album.";
	$title = "New comment!";
	$link = "single_album.php?name=".$_POST['title'];
	$stmt = $db->prepare("INSERT INTO `rss` values(null, ?, ?, ?, current_timestamp())");
	$stmt->bind_param('sss', $title, $link, $description);
	$stmt->execute();


	$db->close();
	header('location: /tw/'.$_SESSION['prev_page']);
 ?>