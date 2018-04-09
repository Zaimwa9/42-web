<?php
	include '../connect.php';
	include '../Model/Users.php';
	session_start();
	foreach($_POST as $key => $input) {
		$_POST[$key] = htmlentities($input);
	}
	if ($_POST['submit'] === 'OK' && ($_POST['usr_pwd']) && ($_POST['usr_email'])) {
    $_POST['usr_pwd'] = hash("whirlpool", $_POST['usr_pwd']);
		if (($user = fetch_unique_user($conn, $_POST))) {
			$_SESSION['user'] = $user;
      if ($_SESSION['user']['usr_id'])
        $_SESSION['isAuthenticated'] = TRUE;
      if ($_SESSION['user']['usr_role'] === "admin") {
        $_SESSION['isAdmin'] = TRUE;
			} else {
				$_SESSION['isAdmin'] = FALSE;
			}
			$redirect_url = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/rush00/index.php";
			header('Location: ' . $redirect_url);
		} else {
			$redirect_url = "http://" . $_SERVER[HTTP_HOST] . "/rush00/index.php";
			echo('<script>alert("Erreur, couple email / mot de passe incorrect")</script>');
			header('Refresh: 0.1;' . $redirect_url);
		}
	}
?>
