<?php
if (isset($_SESSION['cart']) === false || !$_SESSION['cart'])
	echo "<p>votre panier est vide\n</p>";
else
{
	echo "<p>votre panier:<br>";
	foreach($_SESSION['cart'] as $key => $value)
	{
		#print_r($value);
		if ($key === "total")
		{
			$total = $value;
		}
		else
		{
			echo "<form action='./Controllers/remove_from_cart.php' method='post'>" . $value['pd_name'] . ": " . $value['quantities'] . 
				"  <select name='quantity'>
			<option value='-1'>-1</option>
			</select>
			<button name='". $value['pd_id'] . "' value='add_to_cart'>Remove 1 item</button>
			</form></div><br>";
		}
	}
	echo "total: " . $total;
	echo "</p>";
	echo "<a href='./erase_cart.php'>vider le panier</a>";
}
?>
