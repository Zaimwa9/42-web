<?php
include "../connect.php";
include "../Model/Users.php";

foreach($_POST as $key => $input) {
	$_POST[$key] = htmlentities($input);
}
if ($_POST['submit'] = "SUPPRIMER")
{
  foreach ($_POST as $key => $value)
  {
    //fetch_unique_product();
    if ($key == 'submit')
    {
      break;
    }
    else if ($value == 1) {
      echo "You can't delete the admin account... <br>";
    }
    else {
      $user['usr_id'] = $value;
      delete_user($conn, $user);
    }
 	}
}
?>
<html>
<a href="http://192.168.99.100:8100/rush00/admin.php">Go back</a>
</html>
