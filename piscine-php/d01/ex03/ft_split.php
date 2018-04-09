<?php
function ft_split($str)
{
	$result = array_filter(explode(' ', $str));
	sort($result);
	return $result;
}
?>
