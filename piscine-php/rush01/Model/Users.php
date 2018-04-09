<?php
include '../connect.php';

function fetch_all_users($conn) {
	$sql = "SELECT * FROM Users";
	$sql_result = mysqli_query($conn, $sql);
	while ($tmp = mysqli_fetch_assoc($sql_result)) {
		$final[] = $tmp;
	}
	return ($final);
}

function fetch_unique_user($conn, $user) {
	$sql = "SELECT * FROM Users WHERE usr_id='" . $user['usr_id'] . "'" . " OR usr_email='" . $user['usr_email'] . "'";
	$sql_result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	return ($sql_result);
}

function update_user($conn, $field, $user) {
	$sql = "UPDATE Users
		SET " . $field . "='" . $user[$field] . "' WHERE usr_id=" . $user['usr_id'] . " AND usr_pwd='" . $user['usr_pwd'] . "'";
	if (mysqli_query($conn, $sql)) {
		echo "Successful update";
	} else {
		echo "Error updating user: " . mysqli_error($conn);
		echo "<br>";
	}
}

function delete_user($conn, $user) {
	$sql = "DELETE FROM Users WHERE usr_id='" . $user['usr_id'] . "'" . " OR usr_email='" . $user['usr_email'] . "'";

	if (mysqli_query($conn, $sql)) {
		echo "User successfully deleted";
		return TRUE;
	} else {
		echo "Error deleting User: " . mysqli_error($conn);
		echo "<br>";
		return FALSE;
	}
}

function insert_user($conn, $newuser, $role) {
	$sql = "INSERT INTO Users (
		usr_firstname,
		usr_lastname,
		usr_birth_date,
		usr_pwd,
		usr_email,
		usr_location,
		usr_role
  )
  VALUES (" . "'" . $newuser['usr_firstname'] . "', '" .
       $newuser['usr_lastname'] . "', '" . $newuser['usr_birth_date'] . "', '" . $newuser['usr_pwd'] . "', '"
          . $newuser['usr_email'] . "', '" . $newuser['usr_location'] . "', '" . $role . "')";
  if (mysqli_query($conn, $sql)) {
	  echo "User successfully added";
	  echo "<br>";
		return (TRUE);
  } else {
	  echo "Error adding User: " . mysqli_error($conn);
	  echo "<br>";
		return (FALSE);
  }
}

function isAuthenticated($conn, $user) {
	$sql = "SELECT * FROM Users WHERE usr_email='" . $user['usr_email'] . "'". " AND usr_pwd='" . $user['usr_pwd'] . "'";
	if (($sql_result = mysqli_query($conn, $sql))) {
		$myuser = mysqli_fetch_assoc($sql_result);
		echo "Correct User\n";
		return ($myuser);
	} else {
		echo "Mauvais couple email/password\n";
		return (FALSE);
	}
}
// $user['usr_id'] = 14;
$user['usr_firstname'] = 'Quentin';
$user['usr_lastname'] = 'RubyniumMarried';
$user['usr_birth_date'] = "2016-10-07";
$user['usr_pwd'] = 'yo';
$user['usr_email'] = 'diwadoo@hotmail.com';
$user['usr_location'] = 'Paris';
$user['usr_level'] = 'beginner';
$user['usr_role'] = 'user';

$needle['usr_id'] = 2;

//insert_user($conn, $user, 'admin');
// if (($myuser = isAuthenticated($conn, $user))) {
// 	echo "hello\n";
// } else {
// 	echo "pas bon";
// }
//
?>
