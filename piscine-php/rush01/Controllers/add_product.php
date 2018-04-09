<?php
include '../connect.php';
include '../Model/Products.php';
include './check_inputs.php';

foreach($_POST as $key => $input) {
	$_POST[$key] = htmlentities($input);
}

if (check_product_inputs($_POST) == FALSE)
  echo "<br>Erreur !";
else {
  if ($_POST['submit'] = "AJOUTER")
  {
    if (fetch_unique_product($conn, $_POST))
    {
      echo "Ce produit existe déjà !";
    }
    else {
      $_POST['pd_weigth'] = intval($_POST['pd_weight']);
      insert_products($conn, $_POST);
    }
  }
}
?>
<html>
<a href="http://192.168.99.100:8100/rush00/admin.php">Go back</a>
</html>
