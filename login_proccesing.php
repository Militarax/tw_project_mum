<?php
	include 'connection.php';
	$db = mysqli_connect($host, $user, $password, $database) or die("Error" . mysqli_error($db));
	$user_email = filter_var(trim($_POST['email']), FILTER_SANITIZE_STRING);
	$user_password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
	$result = $db->query("select * from `users` where email = '$user_email' and password = md5('$user_password')") or die("mysql_error");
	$row = $result->fetch_assoc();
	$db->close();

	if (is_null($row)) {
		header('Location: /tw/login.php');
	}
	else {
		session_start();
		$_SESSION['email'] = $user_email;
		$_SESSION['id'] = $row['id'];
		$_SESSION['admin'] = $row['admin'];
		header('Location: /tw/index.php');
	}
?>