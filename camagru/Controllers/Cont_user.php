<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/Classes/Picture.class.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/Classes/User.class.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/Classes/Social.class.php';

foreach($_POST as $key => $input)
$_POST[$key] = htmlentities($input);

foreach($_GET as $key => $input)
$_GET[$key] = htmlentities($input);

if (isset($_GET['login'])) {
  $pics = Picture::fetchAllPicturesByAuthor($_GET['login']);
  foreach ($pics as $pic) {
    $pic['posted_at'] = date('d M Y', strtotime(substr($pic['posted_at'], 10)));
    $resp[] = $pic;
  };
  // file_put_contents('./temoin', $resp . "\n");
  echo(json_encode($resp));
}

if (isset($_POST['oldlogin']) && isset($_POST['newlogin'])) {
  if (User::fetchUserByLogin($_POST['newlogin'])) {
    header('Response-code: 409 - Login already in use', true, 409);
    return ;
  } else {
    User::updateLogin($_POST['newlogin'], $_POST['oldlogin']);
    Picture::updateUserLogin($_POST['newlogin'], $_POST['oldlogin']);
    Social::updatePosterLogin($_POST['newlogin'], $_POST['oldlogin']);
    Social::updateAuthorLogin($_POST['newlogin'], $_POST['oldlogin']);
    $_SESSION['login'] = $_POST['newlogin'];
  }
}

if (isset($_POST['oldemail']) && isset($_POST['newemail'])) {
  if (User::fetchUserByEmail($_POST['newemail'])) {
    header('Response-code: 418 - Email already in use', true, 418);
    return ;
  } else {
    User::updateEmail($_POST['newemail'], $_POST['oldemail']);
    $_SESSION['email'] = $_POST['newemail'];
  }
}

if (isset($_POST['action']) && isset($_POST['picture_id'])) {
  if ($_POST['action'] == 'delete') {
    Picture::deletePicture($_POST['picture_id']);
    Social::deleteSocByPic($_POST['picture_id']);
  }
}

// update notifs

if (isset($_POST['login']) && isset($_POST['notifs']) && isset($_POST['action'])) {
  User::updateNotifs($_POST['login'], $_POST['notifs']);
  $_SESSION['notif'] = !$_SESSION['notif'];
}
?>