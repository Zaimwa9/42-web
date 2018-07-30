<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/Classes/User.class.php";
session_start();

?>

<head>

  <link rel="stylesheet" href="../public/css/feed.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>

<div class="container-fluid">
  <?php
  include $_SERVER['DOCUMENT_ROOT'] . '/Views/header.php';
  include $_SERVER['DOCUMENT_ROOT'] . '/Views/picture_feed.php';
  include $_SERVER['DOCUMENT_ROOT'] . '/Views/footer.php';
  ?>
</div>
