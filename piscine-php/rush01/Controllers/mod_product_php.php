<?php
include "../connect.php";
include "../Model/Products.php";
include_once "../Model/Categories.php";

foreach($_POST as $key => $input) {
	$_POST[$key] = htmlentities($input);
}

if ($_POST['submit'] === 'MODIFIER')
{
  foreach ($_POST as $field => $value)
  {
    if ($field !== 'submit') {
      update_product($conn, $field, $_POST);
    }
  }
}
?>
<html>
<a href="http://192.168.99.100:8100/rush00/admin.php">Go back</a>
</html>
