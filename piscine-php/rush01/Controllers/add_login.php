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
      echo "Cette utilisateur existe déjà !";
    } else {
      $_POST['usr_pwd'] = hash("whirlpool", $_POST['usr_pwd']);
      insert_user($conn, $_POST, 'user');
		}
  }
?>
<html>
<a href="http://192.168.99.100:8100/rush00/admin.php">Go back</a>
</html>
