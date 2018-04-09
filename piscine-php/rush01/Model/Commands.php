<?php
include '../connect.php';

function insert_command($conn, $command) {
	$address = "35 rue greneta";
	$sql = "INSERT INTO Commands (
		cmd_ref,
		usr_id,
		total_amount,
		products_cart,
		number_products,
		delivery_address
	)
	VALUES (" . "'" . $command['cmd_ref'] . "', '" .
			 $command['usr_id'] . "', '" . $command['total_amount'] . "', '" . $command['products_cart'] . "', '"
					. $command['number_products'] . "', '" . $address . "', '" . $role . "')";
	if (mysqli_query($conn, $sql)) {
		echo "Command successfully added";
		echo "<br>";
		return (TRUE);
	} else {
		echo "Error adding command: " . mysqli_error($conn);
		echo "<br>";
		return (FALSE);
	}
}
?>
