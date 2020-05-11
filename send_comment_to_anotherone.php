<?php 
	session_start();	
	if(!isset($_POST['comment']) || !isset($_SESSION['email'])) {
		header('location: /tw/login.php');
	}
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
	$stmt = $db->prepare("INSERT INTO personalcomments VALUES(NULL, ?, ?, ?, (select sysdate()))");
	$stmt->bind_param('sss', $_POST['id'], $_SESSION['id'], $_POST['comment']);
	$stmt->execute();


	$result = $db->query("select * from users where id = ".$_POST['id']);
	$email_was_commented = $result->fetch_assoc()['email'];
	$email = $_SESSION['email'];
	$description = $email." commented ".$email_was_commented." page.";
	$title = "New comment!";
	$link = "profile.php?email=".$email_was_commented;
	$stmt = $db->prepare("INSERT INTO `rss` values(null, ?, ?, ?, current_timestamp())");
	$stmt->bind_param('sss', $title, $link, $description);
	$stmt->execute();


	$db->close();
	header('location: /tw/'.$_SESSION['prev_page']);
 ?>