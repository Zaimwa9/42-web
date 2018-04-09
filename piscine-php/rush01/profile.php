<?php
	include "./connect.php";
	session_start();
	date_default_timezone_set('Europe/Warsaw');
	$user = $_SESSION['user'];
	$info['Nom'] = ucfirst($user['usr_firstname']) . " " . ucfirst($user['usr_lastname']);
	$info['Age'] = round((time() - strtotime($user['usr_birth_date'])) / (60 * 60 * 24 * 365));
	$info['Email'] = $user['usr_email'];
	$info['Location'] = ucfirst($user['usr_location']);
	$info['Maitrise'] = ucfirst($user['usr_level']);

?>

<html>
	<?php
		include "./headnav.php";
		include "./navbar.php";
	?>
	<h1> Wouaw nice profile </h1>
	<div class="profile">
		<img src="http://photoclub.canadiangeographic.ca/static/1/images/global/neutral14.png"/>
		<?php
			foreach($info as $key => $usr_data) {
		?>
		<li>  <?php echo ($key . " : " . ($usr_data));} ?></li>
	</div>
	<br>
	<?php
	if ($_SESSION['isAdmin'] == FALSE)
	{
	?>
	<form action="./Controllers/delete_account.php">
		<button>Supprimer son compte</button>
	</form>
	<?php
	}
	?>
</html>
