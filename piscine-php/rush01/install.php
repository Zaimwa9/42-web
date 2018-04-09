<?php
  @include "./Model/Products.php";
	@include "./Model/Categories.php";
  @include "./Model/Users.php";
  @include "./init_data.php";
  // creates a database $dbName through $conn
	date_default_timezone_set('Europe/Warsaw');
  function create_db($conn, $dbName)
  {
    $sql = "CREATE DATABASE " . $dbName;
    echo "Database created successfully";
        if (mysqli_query($conn, $sql)) {
        echo "<br>";
    } else {
        echo "Error creating database: " . mysqli_error($conn);
        echo "<br>";
    }
  }

  include './connect.php';
  $dbName = "rush00";
  create_db($conn, $dbName);
  mysqli_select_db($conn, $dbName);
  $sql = "DROP TABLE IF EXISTS Products";
  if (mysqli_query($conn, $sql)) {
      echo "Products deleted successfully";
      echo "<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
      echo "<br>";
  }
  $sql = "DROP TABLE IF EXISTS Users";
  if (mysqli_query($conn, $sql)) {
      echo "Users deleted successfully";
      echo "<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
      echo "<br>";
  }
  $sql = "DROP TABLE IF EXISTS Categories";
  if (mysqli_query($conn, $sql)) {
      echo "Categories deleted successfully";
      echo "<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
      echo "<br>";
  }
  $sql = "DROP TABLE IF EXISTS Commands";
  if (mysqli_query($conn, $sql)) {
      echo "Commands deleted successfully";
      echo "<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
      echo "<br>";
  }
  // PRODUCTS TABLE
  $sql = "CREATE TABLE Products (
  pd_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  pd_name VARCHAR(30) NOT NULL UNIQUE,
  pd_price INT(6),
  pd_stock INT(6),
  pd_date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  pd_onsale FLOAT(3),
  pd_categories VARCHAR(2000),
  pd_color ENUM('Marron', 'Bleu', 'Rouge', 'Jaune', 'Noir', 'Bois') NOT NULL,
  pd_weight INT(6),
  pd_width INT(6),
  pd_height INT(6),
  pd_img VARCHAR(2000) NOT NULL DEFAULT '/public_html/img/default.jpg',
  pd_featured BOOLEAN DEFAULT FALSE
  )";

  if (mysqli_query($conn, $sql)) {
      echo "Products have been created successfully";
      echo "<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
      echo "<br>";
  }

  if (mysqli_query($conn, $sql)) {
      echo "Products have been populated successfully";
      echo "<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
      echo "<br>";
  }

  // USERS TABLE
  $sql = "CREATE TABLE Users (
  usr_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usr_firstname VARCHAR(20) NOT NULL,
  usr_lastname VARCHAR(20) NOT NULL,
  usr_date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
  usr_birth_date DATE,
  usr_pwd VARCHAR(300) NOT NULL,
  usr_email VARCHAR(30) UNIQUE,
  usr_location VARCHAR(60),
  usr_level ENUM('beginner', 'intermediate', 'advanced') NOT NULL DEFAULT 'beginner',
  usr_role ENUM('user','admin')
  )";

  if (mysqli_query($conn, $sql)) {
      echo "Users have been created successfully";
      echo "<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
      echo "<br>";
  }

  // Categories table
  $sql = "CREATE TABLE Categories (
    cat_id INT(6) AUTO_INCREMENT PRIMARY KEY,
    cat_name VARCHAR(3000) UNIQUE
  )";

  if (mysqli_query($conn, $sql)) {
      echo "Categories have been created successfully";
      echo "<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
      echo "<br>";
  }

  // Categories Commands
  $sql = "CREATE TABLE Commands (
    cmd_ref INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usr_id INT(6),
    total_amount INT(6),
    products_cart VARCHAR(10000) NOT NULL,
    number_products INT(6),
    cmd_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    delivery_address VARCHAR(30) NOT NULL
  )";

  if (mysqli_query($conn, $sql)) {
      echo "Commands have been created successfully";
      echo "<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
      echo "<br>";
  }

  foreach ($newproduct as $instance)
  {
    insert_products($conn, $instance);
  }

	foreach($category as $cat)
	{
		add_category($conn, $cat);
	}


  $admin['usr_firstname'] = "admin";
  $admin['usr_lastname'] = "admin";
  $admin['usr_birth_date'] = date("Y-m-d H:i:s");
  $admin['usr_pwd'] = "admin";
  $admin['usr_email'] = "admin@admin.com";
  $admin['usr_location'] = "Paris";
  $admin['usr_role'] = "admin";
  insert_user($conn, $admin, 'admin');
  // close the connection
  mysqli_close($conn);
?>
