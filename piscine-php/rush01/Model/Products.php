<?php
include '../connect.php';

function fetch_products($conn) {
    $sql = "SELECT * FROM Products";
    $sql_result = mysqli_query($conn, $sql);
		while ($tmp = mysqli_fetch_assoc($sql_result)) {
			$final[] = $tmp;
		}
    return ($final);
}

function fetch_unique_product($conn, $product) {
    $sql = "SELECT * FROM Products WHERE pd_id='" . $product['pd_id'] ."' OR pd_name='" . $product['pd_name'] . "'";
    $sql_result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    return ($sql_result);
}

function insert_products($conn, $newproduct){
    $sql = "INSERT INTO Products (
        pd_name,
        pd_price,
        pd_stock,
        pd_onsale,
        pd_categories,
        pd_color,
        pd_weight,
        pd_width,
        pd_height,
        pd_img,
        pd_featured
    )
    VALUES (" . "'" . $newproduct['pd_name'] . "', '" .
         $newproduct['pd_price'] . "', '" . $newproduct['pd_stock'] . "', '" . $newproduct['pd_onsale'] . "',  '" . $newproduct['pd_categories'] . "', '" . $newproduct['pd_color'] . "', '"
            . $newproduct['pd_weight'] . "', '" . $newproduct['pd_width'] . "', '" . $newproduct['pd_height'] . "', '" . $newproduct['pd_img'] . "', '" . $newproduct['pd_featured'] . "')";

    if (mysqli_query($conn, $sql)) {
     echo "Products have been created successfully";
     echo "<br>";
    } else {
      echo "Error adding new product: " . mysqli_error($conn);
      echo "<br>";
    }
}

function update_product($conn, $field, $product) {
	$sql = "UPDATE Products
		SET " . $field . "='" . $product[$field] . "' WHERE pd_id='" . $product['pd_id'] . "' OR pd_name='" . $product['pd_name'] ."'";
  if (mysqli_query($conn, $sql)) {
		echo "Successful update of '" . $field . "' to '". $product[$field] . "' <br>";
	} else {
		echo "Error updating product: " . mysqli_error($conn);
		echo "<br>";
	}
}

function delete_product($conn, $product) {
  $sql = "DELETE FROM Products WHERE pd_id=" . $product['pd_id'];
	if (mysqli_query($conn, $sql)) {
		echo "Product successfully deleted";
    echo "<br>";
  } else {
		echo "Error deleting product: " . mysqli_error($conn);
		echo "<br>";
	}
}
?>
