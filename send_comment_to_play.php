<?php 
	session_start();	
	if(!isset($_POST['id']) || !isset($_SESSION['email'])) {
		header('location: /tw/login.php');
	}
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
	$stmt = $db->prepare("INSERT INTO playcomments VALUES(NULL, ?, ?, ?, (select sysdate()))");
	$stmt->bind_param('sss', $_SESSION['id'], $_POST['id'], $_POST['comment']);
	$stmt->execute();


	$email = $_SESSION['email'];
	$description = $email." commented ".$_POST["name"].' - '.$_POST["title_track"]." track.";
	$title = "New comment!";
	$link = "comment_a_play.php?id=".$_POST['id'];
	$stmt = $db->prepare("INSERT INTO `rss` values(null, ?, ?, ?, current_timestamp())");
	$stmt->bind_param('sss', $title, $link, $description);
	$stmt->execute();


	$db->close();
	header('location: /tw/'.$_SESSION['prev_page']);
 ?>