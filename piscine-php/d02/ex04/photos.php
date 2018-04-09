#!/usr/bin/php
<?php
	array_shift($argv);
	preg_match("#w{3}.[\w]*.\w*[/]?#", $argv[0], $matches);
	$url = $matches[0];
	if ($matches[0])
		$url = $matches[0];
	else
	{
		if (substr($argv[0], 0, 5) === "https")
			preg_match("#https://([\w]*.\w*)[/]?#", $argv[0], $matches);
		else if (substr($argv[0], 0, 4) === "http")
			preg_match("#http://([\w]*.\w*)[/]?#", $argv[0], $matches);
		$url = "www.".$matches[1];
	}
	if (substr($url, -1) === "/")
		$url = str_replace("/", "", $url);
	if (!($c = curl_init($argv[0])))
	{
		print("Error\n");
		return ;
	} else {
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
	}
	if ($str = curl_exec($c))
	{
		if (strpos($url, "-"))
			$url = str_replace("-", "\-", $url);
		@mkdir($url, 0755);
		preg_match_all('#(<img[\w\W]*?)(src=")([\w\W]*?)([\w\W]*?.[\w]{2,4}?[?"])#', $str, $matches, PREG_SET_ORDER);
		foreach($matches as $elem)
		{
			$dlurl = str_replace(substr($elem[4], -1), "", $elem[4]);
			if (!preg_match("/http(s?)/", $dlurl))
			{
				$dlurl = trim($url) . $dlurl;
			}
			$name = explode('/', $elem[4]);
			if (ctype_alpha(substr($name[4], - 1)) === false)
				$name = str_replace(substr($name[4], -1), "", $name);
			$filename = str_replace('"', "", $name[count($name) - 1]);
			$dest = './' . $url . '/' . str_replace('"', "", $name[count($name) - 1]);
			if (substr($dest, -4) === ".png" || substr($dest, -4) === ".jpg" || substr($dest, -4) === ".svg" || substr($dest, -4) === ".gif" || substr($dest, -5) === ".jpeg") {
				$d = curl_init($dlurl);
				$f = fopen($dest, w);
				curl_setopt($d, CURLOPT_FILE, $f);
				curl_setopt($d, CURLOPT_HEADER, 0);
				curl_exec($d);
				curl_close($d);
				fclose($f);
			}
		}
			curl_close($c);
	}
	else
	{
		print("Error\n");
	}
?>
