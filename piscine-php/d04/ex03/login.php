<?php
	include "auth.php";

	$user = [
		"login" => $_GET['login'],
		"passwd" => $_GET['passwd']
		];
	if (auth($user['login'], $user['passwd'])) {
		if (session_start()) {
			$_SESSION['loggued_on_user'] = $user['login'];
			echo("OK\n");
			return ;
		}
	} else {
		if (session_start()) {
			$_SESSION['loggued_on_user'] = "";
			echo("ERROR\n");
			return ;
		}
	}
?>
