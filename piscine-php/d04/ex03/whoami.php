<?php
if (session_start()) {
	if ($_SESSION['loggued_on_user'] !== "") {
		echo ($_SESSION['loggued_on_user'] . "\n");
		return ;
	} else {
		echo ("ERROR\n");
		return ;
	}
}
?>
