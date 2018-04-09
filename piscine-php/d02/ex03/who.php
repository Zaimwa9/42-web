#!/usr/bin/php
<?php
$file = fopen("/var/run/utmpx", r);
date_default_timezone_set('Europe/Paris');

while ($data = fread($file, 628))
{
	$readable = unpack("a256login/a4id/a32shell/ipid/itype/I2timestamp/a256host/i16misc", $data);
	if ($readable[timestamp2] != 0)
		$output[$readable[shell]] = $readable;
}
ksort($output);
foreach($output as $elem)
{
	print($elem[login] . "    ");
	print($elem[shell] . "  ");
	print(date("M j H:i", $elem[timestamp1]));
	print("\n");
}
?>
