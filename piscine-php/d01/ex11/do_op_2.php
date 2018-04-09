#!/usr/bin/php
<?php
function ft_split_nosort($str)
{
	$result = array_filter(explode(' ', $str));
	return $result;
}

if ($argc != 2) {
	echo "Incorrect Parameters\n";
	return ;
}

if (count(array_filter(explode(' ', $argv[1]))) > 3) {
	echo "Syntax Error\n";
	return ;
};

$my_calcul = preg_replace('/\s+/', '', $argv[1]);
$my_calcul = ft_split_nosort($my_calcul)[0];
$operators = array("/", "+", "-", "%", "*");

foreach ($operators as $op)
{
	$my_array = explode($op, $my_calcul);
	if (count($my_array) > 1)
	{
		array_push($my_array, $op);
		break;
	}
}

if (is_numeric($my_array[0]) && is_numeric($my_array[1])) {
	switch ($my_array[2]) {
		case "+":
			$result = $my_array[0] + $my_array[1];
			break;
		case "-":
			$result = $my_array[0] - $my_array[1];
			break;
		case "%":
			$result = $my_array[0] % $my_array[1];
			break;
		case "/":
			$result = $my_array[0] / $my_array[1];
			break;
		case "*":
			$result = $my_array[0] * $my_array[1];
			break;
		default:
			$result = "Syntax Error";
	}
}
else
	$result = "Syntax Error";
print($result . "\n");
?>
