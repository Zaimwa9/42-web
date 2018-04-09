#!/usr/bin/php
<?php
	$result = array_shift($argv);
	foreach ($argv as $elem)
	{
		print($elem . "\n");
	}
?>
