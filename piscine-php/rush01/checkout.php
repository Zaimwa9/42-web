<?php

include './connect.php';
include './Model/Products.php';
function remove_stock($product)
{
	$warehouse = fetch_unique_product($conn, $product);
	$warehouse['pd_stock']-=$product['pd_stock'];
	update_product($conn, 'pd_stock', $warehouse);
}

	session_start();
if (!$_SESSION['isAuthenticated'])
   {
     $redirect_url = "http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/rush00/signin.php";
     header('Location: ' . $redirect_url);
   }

	$instance=$_SESSION['cart'];

	foreach($instance as $key => $value)
	{
		if ($key !== "total")
			remove_stock($value);
		if ($key == "total")
		$order['total_amount']=$value;
	}
	unset($_SESSION['cart']);
	$order['usr_id']=$_SESSION['user']['firstname'];
	$order['number_products']=5;
	$order['delivery_address']="toto";
	$order['cmd_date']=time();
?>

<!DOCTYPE html>
<html>
<body>
	<br>
	Thank you for your purchase!
</body>
</html>
