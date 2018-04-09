<?php
function auth($login, $passwd)
{
	$file = "../private/passwd";
	$content = unserialize(file_get_contents($file));
	$needle = hash("whirlpool", $passwd);
	foreach($content as $instance) {
		if (in_array($login, $instance)) {
			if ($needle === $instance['passwd'])
				return TRUE;
		}
	}
	return FALSE;
}
?>
