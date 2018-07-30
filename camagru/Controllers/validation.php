<?php
require_once "../Classes/User.class.php";
session_start();
foreach ($_GET as $key => $input) {
  $_GET[$key] = htmlentities($input);
}
if ($verifUser = User::fetchUser($_GET[0])) {
  if ($verifUser->valid_account == true) {
    print("Woops your address has already been verified");
  } else if ($verifUser->login == $_GET[1] && $verifUser->valid_account == false) {
    // we validate the user by updating it
    $verifUser->valid_account = true;
    $verifUser->updateUser(array($verifUser->password, $verifUser->email, $verifUser->valid_account, $verifUser->uid, $verifUser->login));
    print("Account successfully validated");
  }
} else {
  print("Woops sorry there has been an error please contact our Staff");
}
?>
Validation page;