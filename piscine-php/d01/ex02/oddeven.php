#!/usr/bin/php
<?php
	$stdin = fopen('php://stdin', 'r');
	while (!feof(STDIN))
	{
		print("Entrez un nombre: ");
		$my_var = trim(fgets(STDIN));
		if (feof(STDIN))
		{
			print("^D\n");
			break;
		}
		if ($my_var % 2 === 0 && is_numeric($my_var))
		{
			print("Le chiffre ". $my_var . " est Pair\n");
		} elseif ($my_var % 2 == 1 && is_numeric($my_var)) {
			echo "Le chiffre ".$my_var." est Impair\n";
		} elseif (is_numeric($my_var) == false){
			print("'". $my_var. "'" . " n'est pas un chiffre\n");
		}
	}
?>
