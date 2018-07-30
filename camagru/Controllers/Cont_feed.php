<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/Classes/Picture.class.php';
session_start();

foreach($_GET as $key => $input)
  $_GET[$key] = htmlentities($input);

if (!isset($_GET['id'])) {
  $_GET['offset'] = (!isset($_GET['offset']) ? 0 : $_GET['offset']);
  $usr_name = ($_SESSION['user']) ? $_SESSION['login'] : 'null';
  $allPic = Picture::fetchFeedPictures($usr_name, $_GET['offset']);
 // file_put_contents('./test', $pic['picture_id'] . "\n", FILE_APPEND);
  foreach ($allPic as $pic) {
    $pic['posted_at'] = date('d M Y', strtotime(substr($pic['posted_at'], 10)));
    $resp[] = $pic;
  };
  echo(json_encode($resp));
}

if (isset($_GET['id'])) {
  $pic = Picture::fetchPicture($_GET['id']);
  $pic->posted_at = date('d M Y', strtotime(substr($pic->posted_at, 10)));
  echo(json_encode($pic));
}
?>
