#!/usr/bin/php
<?php
function ft_split_nosort($str)
{
	$result = array_filter(explode(' ', $str));
	return $result;
}

function mystrcmp($tab)
{
	$i = 0;
	while ($i < count($tab) + 10)
	{
		$j = 0;
		while ($j < count($tab) - 1)
		{
			$len = 0;
			while ($len < 10 && $len <= strlen($tab[$j]) && $len <= strlen($tab[$j + 1]))
			{
				$c1['value'] = substr($tab[$j], $len, 1);
				$c2['value'] = substr($tab[$j + 1], $len, 1);
				if (is_numeric(substr($c1['value'], 0, 1)))
					$c1['type'] = 1;
				else if (preg_match("/^[A-Za-z]+$/", substr($c1['value'], 0, 1)) == 1)
					$c1['type'] = 0;
				else
					$c1['type'] = 2;
				if (is_numeric(substr($c2['value'], 0, 1)))
					$c2['type'] = 1;
				else if (preg_match("/^[A-Za-z]+$/", substr($c2['value'], 0, 1)) == 1)
					$c2['type'] = 0;
				else
					$c2['type'] = 2;
				if ($c1['type'] < $c2['type'])
					break;
				else if ($c1['type'] > $c2['type']) {
					$tmp = $tab[$j + 1];
					$tab[$j + 1] = $tab [$j];
					$tab[$j] = $tmp;
					break;
				}
				else if ($c1['type'] === $c2['type']) {
					if (strcasecmp(substr($tab[$j], $len, 1), substr($tab[$j + 1], $len, 1)) < 0)
						break;
					else if (strcasecmp(substr($tab[$j], $len, 1), substr($tab[$j + 1], $len, 1)) > 0)
					{
						$tmp = $tab[$j + 1];
						$tab[$j + 1] = $tab [$j];
						$tab[$j] = $tmp;
						break;
					}
				}
				$len = $len + 1;
			}
			$j = $j + 1;
		}
		$i = $i + 1;
	}
	return ($tab);
}

$result = array_shift($argv);
$my_array = [];
$alpha = [];
$numeric = [];
$misc = [];
foreach ($argv as $elem)
{
	$tmp = ft_split_nosort($elem);
	foreach ($tmp as $str)
	{
		if (is_numeric(substr($str, 0, 1)))
			array_push($numeric, $str);
		else if (preg_match("/^[A-Za-z]+$/", substr($str, 0, 1)) == 1)
			array_push($alpha, strval($str));
		else
			array_push($misc, $str);
	}
}

$numeric = mystrcmp($numeric);
$alpha = mystrcmp($alpha);
$misc = mystrcmp($misc);

$my_array = array_merge($alpha, $numeric, $misc);
foreach ($my_array as $elem)
{
	print($elem . "\n");
}
?>
