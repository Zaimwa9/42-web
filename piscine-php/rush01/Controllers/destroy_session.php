<?php
session_start();

if (isset($_SESSION['isAuthenticated'])) {
	unset($_SESSION);
	session_destroy();
	$redirect_url = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/rush00/index.php";
	header('Location: ' . $redirect_url);
}
?>
