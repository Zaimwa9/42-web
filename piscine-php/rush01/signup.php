<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type=text/css href="public_html/css/style.css">
		<title> Ukulele Online Shop</title>
	</head>
	<body>
		<div>
			<? if ($_SERVER['HTTP_REFERER'] === "http://192.168.99.100:8100/rush00gitperso/admin.php") {echo("ERREUR");} ?>
			<form method="post" action="./Controllers/create_login.php" style="width=100px;;margin:auto;border: 5px solid black;">
				Firstname: <input type="text" name="usr_firstname" value="emmanuel" required/><br>
				Lastname: <input type="text" name="usr_lastname" value="macron" required/><br>
				birth date: <input type="date" name="usr_birth_date" value="01/01/1970" required/> (ex: 01/01/1970)<br>
				pwd: <input type="password" name="usr_pwd" value="abc" required><br>
				email: <input type="email" name="usr_email" value="lol@lol.com" required/><br>
				location: <input type="text" name="usr_location" value="groland" required/><br>
				<input type="submit" name="submit" value="OK"/>
			</form>
		</div>
	</body>
</html>
