<?php
require_once "../Classes/User.class.php";
session_start();

foreach ($_POST as $key => $input) {
  $_POST[$key] = htmlentities($input);
}

if (!($currentUser = User::fetchUserByLogin($_POST['login']))) {
  $_SESSION['salut'] = 'yo';
  header('Response-code: 418 - User does not exist', true, 418);
  return ;
}

if (hash('whirlpool', $_POST['password']) === $currentUser->password) {
  foreach ($currentUser as $key => $value) {
    if ($key !== 'password')
      $_SESSION[$key] = $value;
  }
  $_SESSION['user'] = serialize($currentUser);
  header('Response-code: 200', true, 200);
} else {
  header('Response-code: 409 - Login/Password do not match', true, 409);
  return ;
}
?>