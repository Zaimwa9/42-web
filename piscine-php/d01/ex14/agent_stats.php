#!/usr/bin/php
<?php
	$my_var = [];
	$tmp = [];
	while (!feof(STDIN))
	{
		$tmp = explode(';', trim(fgets(STDIN)));
		array_push($my_var, $tmp);
	}
	array_pop($my_var);
	print_r($my_var);
?>
