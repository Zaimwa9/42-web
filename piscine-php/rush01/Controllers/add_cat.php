<?php
  include '../connect.php';
  include '../Model/Categories.php';

	foreach($_POST as $key => $input) {
		$_POST[$key] = htmlentities($input);
	}
  if ($_POST['submit'] = "AJOUTER")
  {
    $category['cat_name'] = ucfirst($_POST['cat_name']);
    add_category($conn, $category);
  }
?>
<html>
<a href="http://192.168.99.100:8100/rush00/admin.php">Go back</a>
</html>
