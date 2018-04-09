<?php
$file = "../private/passwd";
if ($_POST['submit'] !== "OK" || !($_POST['login']) || !($_POST['passwd']))
{
	echo("ERROR\n");
	return ;
} else {
	$user = [
		"login" => $_POST['login'],
		"passwd" => hash("whirlpool", $_POST['passwd'])
	];
	if (file_exists($file))
	{
		$content = unserialize(file_get_contents($file));
		foreach($content as $instance)
		{
			if (in_array($user['login'], $instance))
			{
				echo("ERROR\n");
				return ;
			}
		}
		array_push($content, $user);
	}	else {
		if (!file_exists("../private"))
			mkdir("../private", 0755);
		$content = array($user);
	}
	if (file_put_contents($file, serialize($content)))
		echo("OK\n");
}
?>
