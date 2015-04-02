<?php
	session_start();
	if (!empty($_SESSION['login'])) {
		include 'start.php';
	} else {
		include 'login.php';
	}
?>