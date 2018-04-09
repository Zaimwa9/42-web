<?php
session_start();
header('location: ../index.php');
include '../connect.php';
include '../Model/Products.php';
$masque = array(
	"pd_id" => 0,
	"pd_name" => 0,
	"pd_price" => 0,
);
$keys = array_keys($_POST, "add_to_cart", true);
$qties = $_POST['quantity'];
if (isset($_SESSION['cart']) === false)
{
	$_SESSION['cart']= array();
	$_SESSION['cart']['total'] = 0;
}
$tab = array("pd_id" => $keys[0]);
$tab = array_intersect_key(fetch_unique_product($conn, $tab), $masque);
if (isset($tab['pd_id']) && isset($tab['pd_name']) && isset($tab['pd_price']))
{
	$tab['quantities'] = $qties;
	$in_cart = 0;
	foreach	($_SESSION['cart'] as $key => $value)
	{
		if ($value['pd_name'] === $tab['pd_name'])
		{
			$in_cart = 1;
			if ($_SESSION['cart'][$key]['quantities'] > 0)
			{
				$_SESSION['cart'][$key]['quantities'] -= 1;
				$_SESSION['cart']['total'] -= $tab['pd_price'];
			}
		}
	}
}
else
	echo "ERROR\n";
?>

