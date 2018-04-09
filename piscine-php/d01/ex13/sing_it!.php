#!/usr/bin/php
<?php
	if ($argc != 2)
		return;
	array_shift($argv);
	switch ($argv[0]) {
		case "mais pourquoi cette demo ?":
			$result = "Tout simplement pour qu'en feuilletant le sujet\non ne s'apercoive pas de la nature de l'exo..\n";
			break;
	}
	print($result);
?>
