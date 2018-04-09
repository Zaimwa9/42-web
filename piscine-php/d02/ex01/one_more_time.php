#!/usr/bin/php
<?php
	array_shift($argv);
	$days = array("lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi", "dimanche");
	$months = array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre");
	$date = explode(' ', $argv[0]);
	$time = explode(':', $date[4]);
	$timezone = 'Europe/Warsaw';
	date_default_timezone_set($timezone);

	if (!in_array(strtolower($date[0]), $days) || !in_array(strtolower($date[2]), $months)
		|| !preg_match("/^[0-9]{1,2}$/", $date[1]) || !preg_match("/^[0-9]{4}$/", $date[3])
			|| count($time) != 3)
	{
		print("Wrong Format\n");
		return ;
	}
	if (!preg_match("/^[0-1][0-9]$/", $time[0]) && !preg_match("/^2[0-4]$/", $time[0]))
	{
		print("Wrong Format\n");
		return ;
	}
	if (!preg_match("/^[0-5][0-9]$/", $time[1]) || !preg_match("/^[0-5][0-9]$/", $time[2]))
	{
		print("Wrong Format\n");
		return ;
	}
	$date[2] = array_search(strtolower($date[2]), $months) + 1;
	$tmp = $date[2];
	$date[2] = $date[1];
	$date[1] = $tmp;
	if (!checkdate($date[1], $date[2], $date[3]))
	{
		print("Wrong Date\n");
		return ;
	}
	$formatteddate = implode('/', array_slice($date, 1, 3)) . " " . $date[4];
	print(strtotime($formatteddate) . "\n");
?>
