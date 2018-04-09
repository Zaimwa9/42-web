<?php
if (session_start())
{
	if ($_GET) {
		if ($_GET['submit'] === "OK")
		{
			if ($_GET['login'])
				$_SESSION['login'] = $_GET['login'];
			if ($_GET['passwd'])
				$_SESSION['pwd'] = $_GET['passwd'];
		}
	}
}
?>

<html>
<body>
	<form action="index.php" method="GET">
		Identifiant: <input type="text" name="login" value="<?php if ($_SESSION) echo $_SESSION['login']; else echo "";?>"/>
		<br />
		Mot de passe: <input type="text" name="passwd" value="<?php if ($_SESSION) echo $_SESSION['pwd']; else echo ""?>"/>
		<input type="submit" name="submit" value="OK">
	</form>
</body>
</html>
