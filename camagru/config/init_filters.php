<?php
$root = $_SERVER["DOCUMENT_ROOT"];
require_once $root . '/Classes/Filter.class.php';
$files = scandir($root . '/img/filter/');
foreach($files as $file) {
  if ($file != '.' && $file != '..' && substr($file, 0, 1) != '.') {
    list ($width, $height) = getimagesize($root . '/img/filter/' . $file);
    $name = $file;
    $src = base64_encode(file_get_contents($root . '/img/filter/' . $file));
    Filter::extractFilters(array('name' => $name, 'width' => $width, 'height' => $height, 'encode64' => $src));
  }
  print('done');
}
?>