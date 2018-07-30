<?php
session_start();
require_once "../Classes/Misc.class.php";
require_once "../Classes/User.class.php";

foreach($_POST as $key => $input)
  $_POST[$key] = htmlentities($input);

if (isset($_POST['action']) && $_POST['action'] == 'update' && isset($_POST['old_password']) && isset($_POST['password']) && isset($_POST['login'])) {
  if (($updateUser = User::fetchUserByLogin($_POST['login']))) {
    if (!($updateUser->password == hash('whirlpool', $_POST['old_password']))) {
      header('Response-code: 409 - Bad combination', true, 409);
      return ;
    } else if ($updateUser->valid_account == false) {
      header('Response-code: 421 - You must validate account first', true, 421);
      return ;
    } else {
      $updateUser->password = hash('whirlpool', $_POST['password']);
      $updateUser->updateUser(array($updateUser->password, $updateUser->email, $updateUser->valid_account, $updateUser->uid, $updateUser->login));
    }
  }
}

if (isset($_POST['action']) && $_POST['action'] == 'reset' && isset($_POST['email']) && isset($_POST['login'])) {
  if ($resetUser = User::fetchUserByEmail($_POST['email'])) {
    if (Misc::checkReset($resetUser->email)) {
      header('Response-code: 418 - Reset request already made', true, 418);
      return ;
    } else if ($resetUser->login == $_POST['login']) {
      Misc::sendMail('reset', $resetUser);
      Misc::addReset(array('uid' => $resetUser->uid, 'login' => $resetUser->login, 'email' => $resetUser->email));
    } else {
      header('Response-code: 409 - Bad combination', true, 409);
      return ;
    }
  } else {
    header('Response-code: 409 - Bad combination', true, 409);
    return ;
  }
}

if (isset($_POST['uid']) && isset($_POST['login']) && !(isset($_POST['action']))) {
  if (($user = User::fetchUser($_POST['uid']))) {
    if (Misc::checkReset($user->email)) {
      $user->password = hash('whirlpool', $_POST['password']);
      $user->updateUser(array($user->password, $user->email, $user->valid_account, $user->uid, $user->login));
      if ($_SESSION) {
        foreach($_SESSION as $key => $elem) {
          unset($_SESSION[$key]);
        }
      }
      Misc::removeReset($user->email);
    } else {
      header('Response-code: 418 - No reset request existing', true, 418);
    }
  }
}
?>