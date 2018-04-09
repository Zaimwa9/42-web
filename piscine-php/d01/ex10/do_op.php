#!/usr/bin/php
<?php
if ($argc != 4) {
	echo "Incorrect Parameters\n";
	return ;
}
array_shift($argv);
foreach ($argv as $key => $elem) {
	$argv[$key] = preg_replace('/\s+/', '', $elem);
}
switch ($argv[1]) {
	case "+":
		$result = $argv[0] + $argv[2];
		break;
	case "-":
		$result = $argv[0] - $argv[2];
		break;
	case "%":
		$result = $argv[0] % $argv[2];
		break;
	case "/":
		$result = $argv[0] / $argv[2];
		break;
	case "*":
		$result = $argv[0] * $argv[2];
		break;
}
	print($result . "\n");
?>
