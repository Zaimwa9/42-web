<?php
include "../connect.php";

function fetch_categories($conn) {
	$sql = "SELECT * FROM Categories";
	$sql_result = mysqli_query($conn, $sql);
	while ($tmp = mysqli_fetch_assoc($sql_result)) {
		$final[] = $tmp;
	}
	return ($final);
}

function add_category($conn, $cat) {
	$sql = "INSERT INTO Categories (
		cat_name
  )

  VALUES ('" . $cat['cat_name'] . "')";
	if (mysqli_query($conn, $sql)) {
	 echo "Category successfully added";
	 echo "<br>";
	} else {
		echo "Error adding Category: " . mysqli_error($conn);
		echo "<br>";
	}
}

function delete_category($conn, $category) {
  $sql = "DELETE FROM Categories WHERE cat_id=" . $category['cat_id'];
	if (mysqli_query($conn, $sql)) {
		echo "Category successfully deleted";
    echo "<br>";
  } else {
		echo "Error deleting category: " . mysqli_error($conn);
		echo "<br>";
	}
}

?>
