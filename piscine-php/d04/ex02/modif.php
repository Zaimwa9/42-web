<?php
$file = "../private/passwd";
if ($_POST['submit'] !== "OK" || !($_POST['login']) || !($_POST['oldpw']) || !($_POST['newpw']))
{
	echo("ERROR\n");
	return ;
} else {
	if (!file_exists($file))
	{
		echo("ERROR\n");
		return ;
	} else {
		$content = unserialize(file_get_contents($file));
		$user = [
			"login" => $_POST['login'],
			"oldpw" => $_POST['oldpw'],
			"newpw" => $_POST['newpw']
		];
		foreach ($content as $key => $instance)
		{
			if (in_array($user['login'], $instance))
			{
				if (hash("whirlpool", $user['oldpw']) === $instance['passwd'])
				{
					$instance['passwd'] = hash("whirlpool", $user['newpw']);
					$content[$key] = $instance;
					file_put_contents($file, serialize($content));
					echo ("OK\n");
					return ;
				}
			}
		}
		echo("ERROR\n");
		return ;
	}
}
?>
