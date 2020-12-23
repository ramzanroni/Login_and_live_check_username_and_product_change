<?php
	session_start();
	if (isset($_SESSION['mysession'])) {
		header("Location: home.php");
	}
	else if (isset($_SESSION['mysession']) !="") {
		header("Location: home.php");
	}
	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['mysession']);
		header("Location: index.php");
	}
?>