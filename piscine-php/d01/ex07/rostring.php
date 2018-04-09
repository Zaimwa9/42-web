#!/usr/bin/php
<?php
function ft_split_nosort($str)
{
	$result = array_filter(explode(' ', $str));
	return $result;
}
if ($argc <= 1)
	return;
$result = ft_split_nosort($argv[1]);
array_push($result, $result[0]);
array_shift($result);
$count = count($result);
foreach ($result as $key => $elem)
{
	print($elem);
	if ($count != ($key + 1))
	{
		print(" ");
	}
}
print("\n");
?>
