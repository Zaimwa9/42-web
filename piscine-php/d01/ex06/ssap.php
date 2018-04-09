#!/usr/bin/php
<?php
function ft_split_nosort($str)
{
	$result = array_filter(explode(' ', $str));
	return $result;
}

$result = array_shift($argv);
$my_array = [];
foreach ($argv as $elem)
{
	$tmp = ft_split_nosort($elem);
	foreach ($tmp as $str)
	{
		array_push($my_array, $str);
	}
}
sort($my_array);
foreach ($my_array as $elem)
{
	print($elem . "\n");
}
?>
