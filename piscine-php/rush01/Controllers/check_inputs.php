<?php
	include "../connect.php";
  // this function has to take two parameters in the end, so it always redirects to the current $url instead of admin.php
  function check_product_inputs($product)
  {
    if ($product['pd_price'] < 0 || $product['pd_stock'] < 0 || $product['pd_onsale'] < 0)
      {
        echo "Merci d'entrer uniquement des valeurs positives.";
        return (FALSE);
      }
      return (TRUE);
  }
?>
