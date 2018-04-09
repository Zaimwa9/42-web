<?php
  include '../connect.php';
  include '../Model/Users.php';
  session_start();

	foreach($_POST as $key => $input) {
		$_POST[$key] = htmlentities($input);
	}
	
  if ($_POST['submit'] === "OK") {
    if (fetch_unique_user($conn, $_POST)) {
			// Erreur car email deja existant
      header('Location: http://192.168.99.100:8100/rush00/signup.php');
    } else {
      $_POST['usr_pwd'] = hash("whirlpool", $_POST['usr_pwd']);
      insert_user($conn, $_POST, 'user');
			$user = fetch_unique_user($conn, $_POST);
      $_SESSION['user'] = $user;
      if ($_SESSION['user']['usr_id'])
        $_SESSION['isAuthenticated'] = TRUE;
      if ($_SESSION['user']['usr_role'] === "admin") {
        $_SESSION['isAdmin'] = TRUE;
			} else {
				$_SESSION['isAdmin'] = FALSE;
			}
			$redirect_url = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/rush00/index.php";
			header('Location: ' . $redirect_url, true, 302);
		}
  }
?>
