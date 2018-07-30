<?php
// user mandatory logged
session_start();
// require_once "../Classes/User.class.php";
require_once "../Classes/Misc.class.php";
require_once "../Classes/Picture.class.php";
require_once "../Classes/Filter.class.php";

foreach($_POST as $key => $input)
  $_POST[$key] = htmlentities($input);
// CHECKER FORMAT DE l'image etc ... notamment si upload


foreach($_GET as $key => $input)
$_GET[$key] = htmlentities($input);

if (!($_SESSION['user'])) {
  header('Response-code: 403 - Forbidden', true, 403);
  return ;
}
/*
  Upload photo
*/
if (isset($_FILES['img'])) {
  if ($_FILES['img']['name'] != null) {
    $extensions_valides = array('jpg' , 'jpeg' , 'png');
    $extension = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));
    if (!in_array($extension, $extensions_valides)) {
      header('Response-code: 409 - Bad extension', true, 409);
      return ;
    }
    move_uploaded_file($_FILES['img']['tmp_name'], './tmp.' . $extension);

    $_POST['img'] = base64_encode(file_get_contents('./tmp.' . $extension));
    $randfilters = Filter::fetchAllFilters();
    $randfilters = $randfilters[rand(0, count($randfilters) - 1)];
    list($tmpwidth, $tmpheight) = getimagesizefromstring(base64_decode($_POST['img']));
    list($fwidth, $fheight) = getimagesizefromstring(base64_decode($randfilters['encode64']));
    $_POST['width'] = rand($tmpwidth / 10, $tmpwidth / 2); // On donne une taille max entre 10% et 50% de la photo initiale
    $_POST['height'] = rand($tmpheight / 10, $tmpheight / 2);
    $_POST['offsetY'] = rand(0, $tmpwidth - $_POST['width'] * 1.5); // On offset la photo de la taille max initiale moins un peu plus de la taille du filtre
    $_POST['offsetX'] = rand(0, $tmpheight - $_POST['height'] * 1.5);
    $_POST['name'] = $randfilters['filter_name'];
    unlink('./tmp.' . $extension);
  } else {
    header('Response-code: 418 - Empty file', true, 418);
    header('Location: http://localhost:8080/Views/cam.php');
    return;
  }
}

/*
  This is where we start working on the superposition
*/

if (isset($_POST) && ($_POST['img']) && isset($_POST['width']) && isset($_POST['height']) && isset($_POST['offsetY']) && isset($_POST['offsetX']) && isset($_POST['name'])) {
  $img = $_POST['img'];
  $img = str_replace('data:image/png;base64,', '', $img);
  $img = str_replace(' ', '+', $img);
  $picture_id = Misc::gen_pid($_SESSION['login']);

  $base = $img;
  $filterobj = Filter::fetchFilter($_POST['name']);
  $filter = $filterobj->encode64;

  $attFilter['width'] = $_POST['width'];
  $attFilter['height'] = $_POST['height'];
  $attFilter['offsetY'] = $_POST['offsetY'];
  $attFilter['offsetX'] = $_POST['offsetX'];

  $info = getimagesizefromstring(base64_decode($base));

  $final_picture = base64_encode(Misc::mergeImg($base, $filter, $info, $attFilter));

  // Insert the new picture in the database
  $newPic = new Picture(array(
                        'picture_id' => $picture_id,
                        'raw_encode64' => $img,
                        'final_encode64' => $final_picture,
                        'author_id' => $_SESSION['uid'],
                        'author_login' => $_SESSION['login'],
                        'filter' => 2
  ));

/*
  Adding the montage to the database
*/
  if ($newPic->addPicture()) {
    header('Response-code: 200', true, 200);
    if (isset($_FILES['img']))
      header('Location: http://localhost:8080/Views/cam.php');
    return ;
  } else {
    header('Response-code: 500', true, 500);
    return ;
  }
}

if (isset($_GET['action']) && $_GET['action'] == 'fetch') {
  $filters = Filter::FetchAllFilters();
  echo(json_encode($filters));
}
?>