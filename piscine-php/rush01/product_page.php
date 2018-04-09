<?php
	session_start();
	include './Model/Products.php';
	include './connect.php';
	include '.index.php';

	function generate_html_for_product_display_product_page($instance)
		{
			foreach($instance as $key => $value)
			{
				if ($key == "pd_id")
					$id=$value;
				if ($key == "pd_name")
					$name="<div class='product_description'><h1>" . $value . "</h1><br>";
				if ($key == "pd_price")
				{
					$price='<p style="color: blue; font-size: 20px;font-style:italic;">';
					$price.=$value . " BTC"."</p>";
				}
				if ($key == "pd_stock")
					{
					if ($value <= 0)
						$stock="<p>Out of stock!</p>";
					else
						$stock="<p>In stock: $value</p>";
				}
				if ($key == "pd_color")
					$color="<p>$value</p>";
				if ($key == "pd_weight")
					$weight="<p>$value kg</p>";
				if ($key == "pd_width")
					$width="$value";
				if ($key == "pd_height")
					$height="$value";
				if ($key == "pd_img")
					$img="<div class='product_image'><img src='http://192.168.99.100:8100$value' style='max-width:40vw;'></div>";
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
	if ($_GET && $_GET['pd_id'] !== "" && ($data=fetch_unique_product($conn, $_GET)))
			echo generate_html_for_product_display_product_page($data);
	else
		echo "Oh noes, there's nothing in here!\n";
?>
</body>
</html>
