#!/usr/bin/php
<?php
function ft_split_nosort($str)
{
	$result = array_filter(explode(' ', $str));
	return $result;
}
if ($argc != 2)
	return;
if ($argv[1])
{
	$str = array_values(ft_split_nosort($argv[1]));
	$count = count($str);
	foreach ($str as $key => $elem)
	{
		print($elem);
		if ($count != ($key + 1))
		{
			print(" ");
		}
	}
	print("\n");
}
?>
