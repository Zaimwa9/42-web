<?php
include 'connect.php';
include './Model/Products.php';
$sql = "SELECT * FROM Products";
$sql_result = mysqli_query($conn, $sql);
session_start();
$all_products = fetch_products($conn);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type=text/css href="public_html/css/style.css">
		<title> Ukulele Online Shop</title>
</head>
	<body class="bodymat">
<header>
<?php
include "./headnav.php";
include "./navbar.php";
?>
</header>
<section>
<?php
function product_is_featured($instance)
{
	foreach($instance as $key => $product)
		if ($key == "pd_featured" && $product == 1)
			return(TRUE);
	return(FALSE);
}

function generate_html_for_product_display_index($instance)
{
	foreach($instance as $key => $value)
	{
		if ($key == "pd_id")
			$id=$value;
		elseif ($key == "pd_name")
			{
				$name.='<a href="./product_page.php?pd_id=' . $id . '">';
				$name.="<div><div><h3>" . $value . "</h3>"."<br>";
				$name.='</a>';
			}
		elseif ($key == "pd_price")
			$price=$value . " BTC"."<br>";
		elseif ($key == "pd_stock")
		{
			if ($value <= 0)
				$stock="Out of stock!<br>";
			else
				$stock="In stock: $value<br>";
		}
		elseif ($key == "pd_color")
			$color=$value . "</div>";
		elseif ($key == "pd_weight")
			$weight="$value kg<br>";
		elseif ($key == "pd_width")
			$width="$value";
		elseif ($key == "pd_height")
			$height="$value";
		elseif ($key == "pd_img")
			$img.="<div class='img'><img src='http://192.168.99.100:8100$value'></div>";
	}
	$size=$width." x ".$height."<br>";
	$display.="<div class='product'>";
	$display.=$img.$name.$price.$stock.$weight.$size.$color;
	$display.="<form action='./Controllers/add_to_cart.php' method='post'>
			<select name='quantity'>
			<option value='1'>1</option>
			<option value='2'>2</option>
			<option value='3'>3</option>
			<option value='4'>4</option>
			</select>
			<button name='". $id . "' value='add_to_cart'>Add to cart</button>
			</form></div>";
	$display.="</div>";
	return($display);
}

foreach($all_products as $instance)
{
	if (product_is_featured($instance))
		echo (generate_html_for_product_display_index($instance));
}
?>
</section>
	<footer>
<?php
include "cart_side.php";
?>
	</footer>
	</body>
</html>
