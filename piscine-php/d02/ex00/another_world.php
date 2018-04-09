#!/usr/bin/php
<?php
	if (!$argv[1])
		return;
	array_shift($argv);
	$argv[0] = trim($argv[0]);
	$argv[0] = preg_replace("/[ \t]+/", " ", $argv[0]);
	print($argv[0] . "\n");
?>
