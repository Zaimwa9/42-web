<?php
function generate_html_for_product_display($instance)
{
	foreach($instance as $key => $value)
	{
		if ($key == "pd_id")
			$id=$value;
		if ($key == "pd_name")
			$name="<b>" . $value . "</b>"."<br>";
		if ($key == "pd_price")
			$price=$value . " BTC"."<br>";
		if ($key == "pd_stock")
			{
			if ($value <= 0)
				$stock = "Out of stock!<br>";
			else
				$stock = "In stock: $value<br>";
		}
		if ($key == "pd_color")
			$color="$value<br>";
		if ($key == "pd_weight")
			$weight="$value kg<br>";
		if ($key == "pd_width")
			$width="$value";
		if ($key == "pd_height")
			$height="$value";
		if ($key == "pd_img")
			$img = "<img src='http://192.168.99.100:8100$value'><br>";
	}
	$size="<p>".$width." x ".$height."</p>";
	$display.="<div class='product_display'>";
	$display.="<div>" . $img . "</div>" . "<div>" . $name.$price.$stock.$weight.$size.$color . "</div>";
	$display.="<form action='./Controllers/add_to_cart.php' method='post'>
	<select name='quantity'>
	<option value='1'>1</option>
	<option value='2'>2</option>
	<option value='3'>3</option>
	<option value='4'>4</option>
	</select>
	<button name='". $id . "' value='add_to_cart'>Add to cart</button>

	</form>";

	$display.="</div>";
	$display.="</div>";
	return($display);
}
?>
<html>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type=text/css href="public_html/css/style.css">
		<title> Ukulele Online Shop</title>
</head>
<body>
<header>
<?php
	include "./connect.php";
	include "./Model/Products.php";
if (($_SESSION['isAuthenticated'])) {
	include "./logout.php";
	echo ('<div><a href="http://192.168.99.100:8100/rush00/profile.php"><button>Go to profile</button></a></div>');
} else {
	echo ('<div><a href="http://192.168.99.100:8100/rush00/signin.php"><button>Go to login</button></a>');
	echo ('<a href="http://192.168.99.100:8100/rush00/signup.php"><button>Create account</button></a></div>');
}

include "./navbar.php";
?>
</header>
<?php
	$all_products = fetch_products($conn);

	if ($_GET['cat_name'] !== "Toutes") {
		foreach($all_products as $key => $instance) {
			if (in_array($_GET['cat_name'], $instance) || (strpos($instance['pd_categories'], ($_GET['cat_name']))))
				$products[] = $instance;
		}
	} else {
		foreach($all_products as $key => $instance) {
			$products[] = $instance;
		}
	}
	if ($products) {
		foreach($products as $instance) {
			echo (generate_html_for_product_display($instance));
		}
	} else {
		$redirect_url = "http://" . $_SERVER[HTTP_HOST] . "/rush00/index.php";
		echo('<script>alert("Woops ! Rupture de stock dans cette catégorie !")</script>');
		header('Refresh: 0.1;' . $redirect_url);
	}
?>
