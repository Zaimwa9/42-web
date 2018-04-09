<?php
function add_cookie($data)
{
	setcookie($data['name'], $data['value'], time() + 3600);
}

function read_cookie($data, $cookie)
{
	if ($cookie[$data['name']])
		echo ($cookie[$data['name']] . "\n");
	else
		return ;
}

function remove_cookie($data)
{
	setcookie($data['name'], '', time() - 1000);
}

if ($_GET['action'] === "set") {
	add_cookie($_GET);
} elseif ($_GET['action'] === "get") {
	read_cookie($_GET, $_COOKIE);
} elseif ($_GET['action'] === "del") {
	remove_cookie($_GET, $_COOKIE);
}
?>
