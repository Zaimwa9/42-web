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
foreach($_POST as $key => $input) {
	$_POST[$key] = htmlentities($input);
}

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
			$_SESSION['cart'][$key]['quantities'] += $qties;
		}
	}
	if ($in_cart == 0)
		$_SESSION['cart'][] = $tab;
	$_SESSION['cart']['total'] += $qties * $tab['pd_price'];
	foreach ($_SESSION['cart'] as $key => $value)
	{
		echo $key . ": ";
		if ($key === "total")
			echo $value;
		else
		{
			foreach ($value as $key2 =>$elem)
				echo "[" . $key2 . "]" ."= " . $elem. "   ";
		}
		echo "<br><br>";
	}
}
else
	echo "ERROR\n";
?>
