<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . "/Classes/Social.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Classes/User.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Classes/Misc.class.php";

foreach ($_POST as $key => $input) {
  $_POST[$key] = htmlentities($input);
}

foreach ($_GET as $key => $input) {
  $_GET[$key] = htmlentities($input);
}

if ($_POST['type'] == 'comment' && $_POST['action'] != 'remove') {
  Social::addComment(array('poster_login' => $_SESSION['login'],
                            'picture_id' => $_POST['picture_id'],
                            'content' => $_POST['content'],
                            'author_login' => $_POST['author_login'])
  );
  if (($author = User::fetchUserByLogin($_POST['author_login']))) {
    $array = array('email' => $author->email,
                  'content' => $_POST['content'],
                  'login' => $author->login,
                  'poster_login' => $_SESSION['login'],
                  'picture_id' => $_POST['picture_id']
                  );
    if (isset($_SESSION['notif']) && $_SESSION['notif'] == true) {
      Misc::sendMail('newCom', $array);
    }
  };
}

if ($_POST['type'] == 'like' && $_POST['action'] == 'add') {
  if ($_POST['author_login'] == null || $_POST['author_login'] == null) {
    header('Response-code: 500 - Data missing', true, 500);
    return ;
  }
  if (!($like = Social::fetchLikePic($_POST['picture_id'], $_SESSION['login']))) {
    $array = array('poster_login' => $_SESSION['login'],
                  'picture_id' => $_POST['picture_id'],
                  'content' => null,
                  'author_login' => $_POST['author_login']
                  );
    Social::addLike($array);
  }
}

if ($_POST['type'] == 'like' && $_POST['action'] == 'remove') {
  Social::removeLike($_SESSION['login'], $_POST['picture_id']);
}

if ($_POST['type'] == 'comment' && $_POST['action'] == 'remove') {
  if ($_POST['latest'] == false) {
    Social::removeCom($_SESSION['login'], $_POST['picture_id'], $_POST['social_id']);
  } else {
    $coms = Social::fetchComsByPic($_POST['picture_id']);
    // file_put_contents('./temoin2', $coms[0]['social_id']);
    Social::removeCom($_SESSION['login'], $_POST['picture_id'], $coms[0]['social_id']);
  }
}

if (isset($_GET['id']) && isset($_GET['retrieve']) && isset($_GET['user'])) {
  $likes = Social::fetchLikesPage($_GET['id'], $_GET['user']);
  echo(json_encode($likes));
  return ;
}

if (!(isset($_GET['retrieve'])) && isset($_GET['id']) && $_GET['retrieve'] != 1) {
  $offset = ($_GET['offset'] ? $_GET['offset'] : 0);
  $coms = Social::fetchComsByPic($_GET['id'], $_GET['offset']);
  foreach($coms as $key => $com) {
    $coms[$key]['posted_at'] = date('d M Y', strtotime(substr($coms[$key]['posted_at'], 10)));
  }
  echo(json_encode($coms));
  return ;
}

if (isset($_GET['trending'])) {
  $coms = Social::fetchTComs();
  foreach($coms as $key => $com) {
    $coms[$key]['posted_at'] = date('d M Y', strtotime(substr($coms[$key]['posted_at'], 10)));
  }
  echo(json_encode($coms));
}
?>