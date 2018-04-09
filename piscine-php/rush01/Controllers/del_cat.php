<?php
include "../connect.php";
include "../Model/Categories.php";

foreach($_POST as $key => $input) {
	$_POST[$key] = htmlentities($input);
}

if ($_POST['submit'] = "SUPPRIMER")
{
  foreach ($_POST as $key => $value)
  {
    //fetch_unique_product();
    if ($key == 'submit')
    {
      break;
    }
    else {
      $product['cat_id'] = $value;
      delete_category($conn, $product);
    }
 	}
}
?>
<html>
<a href="http://192.168.99.100:8100/rush00/admin.php">Go back</a>
</html>
