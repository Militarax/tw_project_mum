<?php
		session_start();
		session_destroy();
		setcookie('md&mtc', NULL, -1, '/tw');
		header('Location: /tw/index.php'); 
?>