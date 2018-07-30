<?php
require_once "../Classes/User.class.php";
session_start();

foreach ($_POST as $key => $input) {
  $_POST[$key] = htmlentities($input);
}

if (User::fetchUserByLogin($_POST['login'])) {
  header('Response-code: 409 - Login already in use', true, 409);
  return ;
}

if (User::fetchUserByEmail($_POST['email'])) {
  header('Response-code: 418 - Email already in use', true, 418);
  return ;
}

$newUser = new User(array('login' => $_POST['login'], 'password' => hash('whirlpool', $_POST['password']), 'email' => $_POST['email']));
$newUser->addUser();
foreach ($newUser as $key => $value) {
  if ($key != 'password')
    $_SESSION[$key] = $value;
}
$_SESSION['user'] = serialize($newUser);
header('Response-code: 200', true, 200);
?>