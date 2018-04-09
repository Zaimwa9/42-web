<?php
include "../connect.php";
include "../Model/Users.php";
session_start();

if (delete_user($conn, $_SESSION['user'])) {
	$redirect_url = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/rush00/index.php";
	header('Location: ' . $redirect_url);
	include "./destroy_session.php";
}
?>
