<?php
function validate($str) {
	return (strpos($str, " ") + strpos($str, "\n") + strpos($str,"\t") + strpos($str, "\r"));
}
	$email = $_POST['email'];
	$password = trim($_POST['password']);
	$password2 = trim($_POST['password2']);
	$user ='root';
	$db = new mysqli('localhost', $user, '', 'mydb') or die('Unable to connect'); 
	$exists = null;

	if(strcmp($password, $password2) == 0) {
    	$exists = $db->query("select * from `users` where email = '$email'")->fetch_assoc();
    	if (empty($exists)) {
	    	if(validate($password) == 0 && strlen(password) >= 6) {
				$db->query("INSERT INTO `users`(`email`, `password`) VALUES ('$email', md5('$password'))") or die("mysql_error");
		    	header("Location: /tw/login.php");
	    	}
	    	else 
	    		echo 'password contains characters that should not contain';
	    }
	    else 
	    	echo 'such user exists';
	}
	else {
		echo 'passwords does not coencide'; 
		// header("Location: /tw/register.php");
	} 

	$db->close();
?>