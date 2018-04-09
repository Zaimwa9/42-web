<?php
if ($_SERVER['PHP_AUTH_USER'] === "zaz" && $_SERVER['PHP_AUTH_PW'] === "jaimelespetitsponeys")
{
	$image = '../img/42.png';
	$data = base64_encode(file_get_contents($image));
	$src = 'data:image/png;base64,'.$data;
	echo "<html><body>\nBonjour Zaz" . "<br" . "/>" . "\n<img " . "src=" . "'".$src."'" . "></body></html>\n";
}
else
{
	header("WWW-Authenticate: Basic realm=''Espace membres''");
	header('HTTP/1.0 401 Unauthorized');
	echo "<body>Cette zone est accessible uniquement aux membres du site</body>\n";
	exit;
}
?>
