#!/usr/bin/php
<?php
array_shift($argv);
$needle = $argv[0];
array_shift($argv);

foreach ($argv as $elem)
{
	$tmp = explode(':', $elem);
	if ($tmp[0] === $needle)
	{
		$flag = 1;
		$result = $tmp;
	}
}
	$flag === 1 ? print($result[1] . "\n") : print($result[1]);
?>
