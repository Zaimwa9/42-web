<?php
include "../connect.php";
include "../Model/Products.php";

foreach($_POST as $key => $input) {
$_POST[$key] = htmlentities($input);
}

if ($_POST['submit'] = "SUPPRIMER")
{
  foreach ($_POST as $key => $value)
  {
    if ($key == 'submit')
    {
      break;
    }
    else {
      $product['pd_id'] = $value;
      delete_product($conn, $product);
    }
 	}
}
?>
<html>
<a href="http://192.168.99.100:8100/rush00/admin.php">Go back</a>
</html>
